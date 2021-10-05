<?php


namespace app\components;


use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

use app\models\Person;
use app\models\Sms;

use Exception;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class smsInterfaceComponent extends Component
{
	private $mqtt;
	private $smsMessages;

	function __construct()
	{
		try {
			$server = Yii::$app->params['mqttServer'];
			$port = Yii::$app->params['mqttPort'];
			$clientId = Yii::$app->params['mqttClientId'];
			$user = Yii::$app->params['mqttUser'];
			$password = Yii::$app->params['mqttPassword'];

			$this->mqtt = new MqttClient($server, $port, $clientId);

			$settings = (new ConnectionSettings)->setUsername($user)->setPassword($password);
			$this->mqtt->connect($settings);

		} catch (Exception $e) {
			Yii::$app->session->setFlash('error', 'Failed to connect to SMS Gateway');
		}
	}

	function __destruct()
	{
		$this->mqtt->disconnect();
	}

	public function sendSMStoAll($contest_id = null, $message )
	{

		if (!$contest_id) $contest_id = yii::$app->user->identity->profile->contest_id;

		$numbers = ArrayHelper::getColumn(Person::findAll(['contest_id' => $contest_id]), 'telephone');

		foreach ($numbers as $number) {
			$send_to = $this->sanitizeE164($number);
			$this->send($send_to, $message);
		}
	}

	public function sendSMStoOne($number, $message )
	{
		$send_to = $this->sanitizeE164($number);
		$this->send($send_to, $message);
	}

	public function receiveSms()
	{
		$messages = $this->receive();

		foreach ($messages as $filename => $message)
		{
			$sms = new Sms();

			$header = true;
			foreach($message as $row)
			{
				// New Line indicates end of header
				if ($row == "\n") $header = false;

				if ($header)
				{
					if (str_contains($row, 'From: ')) $sms->from = str_replace('From: ', '',$row);
					if (str_contains($row, 'Sent: ')) $sms->sent = str_replace('Sent: ', '',$row);
					if (str_contains($row, 'Received: ')) $sms->received = str_replace('Received: ', '',$row);
				}
				else
				{
					$sms->message .= $row;
				}

			}

			if ($sms->save())
			{
				$file = json_encode(['file'=>$filename]);
				$this->mqtt->publish('sms/receive/delete', $file, 0);
			}

		}
	}

	private function send($number, $message)
	{

		$sms = json_encode(['number' => $number, 'message' => $message]);
		$this->mqtt->publish('sms/send', $sms, 0);
	}

	private function receive()
	{
		// Subscribe to Replies
		$this->mqtt->subscribe('sms/receive/reply', function ($topic, $message){ 
			$this->smsMessages = $message;
			$this->mqtt->interrupt();
		}, MqttClient::QOS_EXACTLY_ONCE);

		// Create Timeout Event on Loop handler
		$this->mqtt->registerLoopEventHandler(function (MqttClient $client, float $elapsedTime) {
            // After 10 seconds, we quit the loop.
            if ($elapsedTime > 10) {
                $client->interrupt();
            }
        });

		// Publish the Feed Request
		$this->mqtt->publish('sms/receive/request', 'feed-me');

		// Wait for the Feed
		$this->mqtt->loop(true);
		
		return json_decode($this->smsMessages);
	}

	private function sanitizeE164($number)
	{

		$phoneUtil = PhoneNumberUtil::getInstance();
		try {
			$clean = $phoneUtil->parse($number, 'NZ');
			$clean = $phoneUtil->format($clean, PhoneNumberFormat::E164);
			$clean = substr($clean, 1);
			return $clean;
		} catch (NumberParseException $e) {
			return '';
		}
	}
}
