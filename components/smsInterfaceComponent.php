<?php


namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;

use app\models\Contest;
use app\models\Pilot;

class smsInterfaceComponent extends Component
{

	private $baseUrl = 'https://rest.clicksend.com/';
	private $username;
	private $password;

	private $client;
	private $request;

	public function init()
	{
		$this->username = Yii::$app->params['clickSendUser'];
		$this->password = Yii::$app->params['clickSendKey'];

		$this->client = new Client(['baseUrl'=> $this->baseUrl]);
		$this->request = $this->client->createRequest()
		->setFormat(Client::FORMAT_JSON);

		$this->request->headers->set('Authorization', 'Basic ' . base64_encode($this->username.':'.$this->password));

	}

	public function getLists()
	{


		$this->request
		->setMethod('GET')
		->setUrl('v3/lists')
		->setData(['limit' => 1000]);

		$response = $this->request->send();

		if ($response->isOK){
			return $response->data['data']['data'];	
		}

		return [];

	}

	public function createList($list_name)
	{

		$existing_lists = \yii\helpers\ArrayHelper::map($this->getLists(), 'list_name', 'list_id');


		if (!array_key_exists($list_name, $existing_lists)){
			$this->request
			->setMethod('POST')
			->setUrl('v3/lists')
			->setData(['list_name' => $list_name]);

			$response = $this->request->send();

			if ($response->isOK){
				return $response->data['data']['list_id'];	
			}
			return null;
		}
		return $existing_lists[$list_name];

	}

	public function getContacts($list_id)
	{

		$this->request
		->setMethod('GET')
		->setUrl("v3/lists/$list_id/contacts")
		->setData(['limit' => 1000]);

		$response = $this->request->send();

		if ($response->isOK){
			return $response->data['data']['data'];	
		}

		return [];

	}


	public function createContacts ($list_id, $contacts = [])
	{

		$existing_contacts = \yii\helpers\ArrayHelper::map($this->getContacts($list_id), 'last_name', 'contact_id');

		foreach ($contacts as $name =>$number)
		{
			if (!array_key_exists($name,$existing_contacts)){
				$this->addContact($list_id, $name, $number);
			}
		}	
	}

	private function addContact ($list_id, $name, $number)
	{

		$this->request
		->setMethod('POST')
		->setUrl("v3/lists/$list_id/contacts")
		->setData([
			"phone_number" => $this->sanitizeE164($number),
			"first_name"=> "",
			"last_name" => $name,
			"address_country" => "NZ"
		]);

		$response = $this->request->send();

		if ($response->isOK){
			return $response->data['data']['contact_id'];	
		}

		return FALSE;

	}
	public function sendSMStoAll($message, $contest_id=null)
	{

		if (!$contest_id) $contest_id = yii::$app->user->identity->profile->contest_id;

		$numbers = ArrayHelper::getColumn(Pilot::findAll(['contest_id'=>$contest_id]),'telephone');
		$numbers = $this->sanitizeE164($numbers);

		foreach ($numbers as $number){
			$this->request
			->setMethod('POST')
			->setUrl('v3/sms/send')
			->setData([
				'messages' => [
					'from' => 'Contest Director',
					'body' => $message,
					'to' => +6141111111,
				]
			]);

			$response = $this->request->send();

		}

		return $response->data;

	}

	public function sendSMStoOne($message, $pilot_id)
	{

		$numbers = ArrayHelper::getColumn(Pilot::findOne($pilot_id),'telephone');
		$numbers = $this->sanitizeE164($numbers);

		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('POST')
		->setFormat(Client::FORMAT_JSON)
		->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
		->setUrl('send.php')
		->setData([
			'messages' => [
				'body' => $message,
				'to' => +6141111111,
				'from' => +6141111111,
			]
		]);

		$response = $this->request->send();

		return $response;

	}

	private function sanitizeE164 ($number){

		$number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);  // Strip to integer only
		$number = str_replace(['-','+'], '', $number);				// Remove any + or -
		$number = ltrim($number, 0);								// remove any Leading zeros
		if (substr($number,0,1)==='2')                              // check for leading number is "2"  ( All NZ Mobile numbers start 02 )
			$number = '64'.$number;                                 // Add Country Code for NZ
		// Otherwise assume the Country code is already added.
		$clean = $number;

		return $clean;

	}
}

?>
