<?php


namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

use yii\httpclient\Client;

class gnzInterfaceComponent extends Component


{
	private $contestList = [];
	private $pilotList = [];
	private $baseUrl = 'https://gliding.net.nz/api';
	private $oauthUrl = 'https://gliding.net.nz/oauth';
	private $waypointList = [];

	// Get Contest List from GNZ Contest website
	//
	//  access with ....  Yii::$app->gnz->getContestList()

	public function getContestList()
	{
		//DebugBreak();
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl('events')
		->setData([
			'timerange' => 'future',
			'gnz' => 'true',
			'other' => 'true',
			'type' => 'competition',
		])
		->send();
		if ($response->isOk) {
			foreach($response->data['data'] as $key=>$values) {
				if ($values['start_date'] < date('Y-m-d', strtotime('+1 year')))
					$this->contestList[$values['id']] = $values['name'];
			}

		}

		return $this->contestList;

	}

	// Get Contest Details from GNZ Contest website
	//
	//  access with ....  Yii::$app->gnz->getContest($id)

	public function getContest($id)
	{
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("events/$id")
		->send();
		if ($response->isOk) 
			return $response->data['data'];

		return false;

	}

	// Get Contest Pilots List from GNZ Contest website
	//
	//  access with ....  Yii::$app->gnz->getPilotList($id)

	public function getPilotList($id)
	{
		$accessToken = $this->getAccessToken();

		$pilot = [];
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("v1/entries")
		->setHeaders([
			'Accept' => 'application/json',
			'Authorization' => 'Bearer '.$accessToken,
		])
		->setData([
			'canceled' => 'false',
			'event_id' => $id,
		])
		->send();

		if ($response->isOk) {
			foreach($response->data['data'] as $key=>$values) {
				if ($values['entry_type']=='pilot' and $values['entry_status']=='entered')
				{
					$pilot_details = $this->getPilotDetails($values['member_id']);
					$this->pilotList[] = [
						'gnz_id' 		=> $values['id'],
						'name' 			=> $values['first_name'].' '.$values['last_name'],
						'rego' 			=> $values['aircraft']['rego'],
						'rego_short' 	=> substr($values['aircraft']['contest_id'],-2),
						'entry_date' 	=> $values['created_at'],
						'telephone'     => $values['mobile'],
						'address1'		=> @$pilot_details['address_1'],
						'address2'		=> @$pilot_details['address_2'],
						'address3'		=> @$pilot_details['city'],
						'postcode'		=> @$pilot_details['zip_post'],
						'trailer'		=> @$values['car_details'],
						'plate'			=> @$values['car_plate'],
						'crew'			=> @$values['crew_name'],
						'crew_phone'	=> @$values['crew_phone'],
					];
				}
			}
			return $this->pilotList;
		}
		else{
			return false;			
		}
	}

	public function getPilotDetails($pilot)
	{
		$accessToken = $this->getAccessToken();

		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("v1/members/$pilot")
		->setHeaders([
			'Accept' => 'application/json',
			'Authorization' => 'Bearer '.$accessToken,
		])
		->send();

		if ($response->isOk) 
			return $response->data['data'];

		return false;

	}

	public function getAircraftTrack($dayDate, $aircraft)
	{
		$accessToken = $this->getAccessToken();

		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("v2/tracking/$dayDate/aircraft/$aircraft")
		->setHeaders([
			'Accept' => 'application/json',
			'Authorization' => 'Bearer '.$accessToken,
		])
		->send();

		if ($response->isOk) 
			return $response->data['data'];

		return false;

	}

	public function getAllTracks($dayDate, $count=1)
	{
		$accessToken = $this->getAccessToken();

		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("v2/tracking/$dayDate/$count")
		->setHeaders([
			'Accept' => 'application/json',
			'Authorization' => 'Bearer '.$accessToken,
		])
		->send();

		if ($response->isOk) 
			return $response->data['data'];

		return false;

	}

	public function getContestTracks($dayDate, $contest_id)
	{
		$data = [];
		$point = [];

		$alltracks = (object)$this->getAllTracks($dayDate, 2);
		$aircraft = \app\models\Pilot::findEvery()
		->innerJoinWith('status')
		->where(['contest_id'=>$contest_id])
		->andWhere(['NOT', ['status' => 1]])
		->select(['rego_short'])
		->column();


		// Search returned data for Contest Aircraft and Update tracks with latest point	
		foreach($alltracks as $track){
			if (in_array(@$track['aircraft']['contest_id'], $aircraft)){
				//$data[$track['aircraft']['contest_id']] = $track['points'][0];
				$point = $track['points'][0];
				$point['rego'] = $track['aircraft']['contest_id'];

				$utc_offset =  date('Z') / 3600;
				$ts = date('Y-m-d H:i:s' , strtotime($utc_offset. ' hours', strtotime($point['thetime']))); 
				$status = 'OK';
				if ($point['alt']- $point['gl'] < 10) $status = "Height";
				if ($point['speed'] < 10) $status = 'Speed';
				if ($ts < date('Y-m-d H:i:s',strtotime('-15 mins'))) $status = 'Slow Update';
				if ($ts < date('Y-m-d H:i:s',strtotime('-2 hours'))) $status = 'No Update';

				$point['status'] = $status;
				
				$data[]=$point;
			}

		}

		// append empty points for any contest aircraft that were not returned in the tracking data for that day
		foreach ($aircraft as $rego){
			if (array_search($rego, array_column($data, 'rego'))===FALSE){ 
				$data[] = ['rego'=>$rego];
			}
		}

		return $data;

	}

	// Get Contest List from GNZ Contest website
	//
	//  access with ....  Yii::$app->gnz->getWaypoints()

	public function getWaypoints()
	{
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl('v1/waypoints')
		->send();

		if ($response->isOk) {
			$this->waypointList = [];
			foreach($response->data['data'] as $key=>$values) {
				$this->waypointList[] = $values['code'];
			}
		}

		return $this->waypointList;	

	}

	// Get Contest List from GNZ Contest website
	//
	//  access with ....  Yii::$app->gnz->getWaypoints()

	public function getWaypointNames()
	{
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl('v1/waypoints')
		->send();

		if ($response->isOk) {
			$this->waypointList = [];
			foreach($response->data['data'] as $key=>$values) {
				$this->waypointList[$values['id']] = $values['name'];
			}
		}

		return $this->waypointList;	

	}

	// Get Contest List from GNZ Contest website
	//
	//  access with ....  Yii::$app->gnz->getWaypoints()

	public function getWaypointDetails($id)
	{
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('GET')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("v1/waypoints/$id")
		->send();

		if ($response->isOk) {
			return $response->data['data'];
		}

		return [];	

	}

	// Oauth Interface Utility Functions
	//

	private function refreshToken()
	{
		// Should not need to refresh a token once generated.
		// Run this Function Manually after editing the Username and Password.
		$client = new Client(['baseUrl'=> $this->oauthUrl]);
		$response = $client->createRequest()
		->setMethod('POST')
		->setFormat(Client::FORMAT_JSON)
		->setUrl("token")
		->setData([
			'grant_type' => 'password',
			'client_id' => '8',
			'client_secret' => Yii::$app->params['gnzSecret'],
			'username' => Yii::$app->params['gnzUser'],
			'password' => Yii::$app->params['gnzPassword'],
			'scope' => '*',
		])
		->send();

		if ($response->isOk)
		{ 
			//return $response->data['access_token'];
			$ini_file = Yii::getAlias('@runtime/gnz_access_token.ini');
			$this->put_ini_file($ini_file , $response->data);
			return $response->data['access_token']; 
		}
		return false;

	}

	private function getAccessToken()
	{
		//return $this->refreshToken();

		$ini_file = Yii::getAlias('@runtime/gnz_access_token.ini');
		$ini_array = parse_ini_file($ini_file, true);
		return $ini_array['access_token'];
	}


	private function put_ini_file($file, $array, $i = 0)
	{
		$str="";
		foreach ($array as $k => $v){
			if (is_array($v)){
				$str.=str_repeat(" ",$i*2)."[$k]".PHP_EOL;
				$str.=put_ini_file("",$v, $i+1);
			}else
				$str.=str_repeat(" ",$i*2)."$k = $v".PHP_EOL;
		}
		if($file)
			return file_put_contents($file,$str);
		else
			return $str;
	}

}

?>
