<?php


namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;

use app\models\Contest;
use app\models\Person;

use Exception;
use libphonenumber;
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
			$this->Send($send_to, $message);
		}
	}

	public function sendSMStoOne($person_id, $message )
	{

		$number = Person::findOne($person_id)->telephone;
		$send_to = $this->sanitizeE164($number);
		$this->Send($send_to, $message);
	}

	private function Send($number, $message)
	{

		$sms = json_encode(['number' => $number, 'message' => $message]);
		$this->mqtt->publish('sms/send', $sms, 0);
	}

	public function receive()
	{
		$this->mqtt->publish('sms/receive/request', 'feed-me');
		$this->mqtt->subscribe('sms/receive/reply', function ($topic, $message){ 
			$this->smsMessages = $message;
			$this->mqtt->interrupt();
		}, MqttClient::QOS_EXACTLY_ONCE);
		$this->mqtt->loop(true,false,10);
		return $this->smsMessages;
	}

	private function on_receive()
	{

	}

	private function sanitizeE164($number)
	{

		$phoneUtil = PhoneNumberUtil::getInstance();
		try {
			$clean = $phoneUtil->parse($number, 'NZ');
			return $phoneUtil->format($clean, PhoneNumberFormat::E164);
		} catch (NumberParseException $e) {
			return '';
		}
	}
}
