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

	private $baseUrl = 'https://api-mapper.clicksend.com/http/v2/';


	public function sendSMStoAll($message, $contest_id=null)
	{

		if (!$contest_id) $contest_id = yii::$app->user->identity->profile->contest_id;

		$numbers = ArrayHelper::getColumn(Pilot::findAll(['contest_id'=>$contest_id]),'telephone');
        $numbers = $this->sanitizeE164($numbers);
        
        
		$client = new Client(['baseUrl'=> $this->baseUrl]);
		$response = $client->createRequest()
		->setMethod('POST')
		->setFormat(Client::FORMAT_JSON)
		->setHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
		->setUrl('send.php')
		->setData([
			'username' => 'info@lymac.co.nz',
			'key' => '3CAA8F32-7C6E-B8A3-D15C-FFD59E14229A',
			'method' => 'sms',
			'to' => '+61411111111',
			'message' => $message,
			'senderid' => 'contestdirectorbot@gnz.co.nz'
		])


		->send();

		return $response;

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
			'username' => 'info@lymac.co.nz',
			'key' => '3CAA8F32-7C6E-B8A3-D15C-FFD59E14229A',
			'method' => 'sms',
			'to' => '+61411111111',
			'message' => $message,
			'senderid' => 'contestdirectorbot@gnz.co.nz'
		])


		->send();

		return $response;

	}

	private function sanitizeE164 ($numbers){
		
		$clean = [];
		
		foreach($numbers as $number)
		{
			$number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);  // Strip to integer only
			$number = str_replace(['-','+'], '', $number);				// Remove any + or -
			$number = ltrim($number, 0);								// remove any Leading zeros
			if (substr($number,0,1)==='2')                              // check for leading number is "2"  ( All NZ Mobile numbers start 02 )
				$number = '64'.$number;                                 // Add Country Code for NZ
				                                                        // Otherwise assume the Country code is already added.
			$clean[] = $number;
		}                             
		
		return $clean;
		
	}
}

?>
