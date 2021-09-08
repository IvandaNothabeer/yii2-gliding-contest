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

use PhpMqtt\Client\MqttClient;

class smsInterfaceComponent extends Component
{
	private $mqtt;

	function __construct()
	{
		try {
			$server = Yii::$app->params['mqttServer'];
			$port = Yii::$app->params['mqttPort'];
			$clientId = Yii::$app->params['mqttClientId'];

			$this->mqtt = new MqttClient($server, $port, $clientId);

			$this->mqtt->connect();
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
		$this->mqtt->publish('sms/message', $sms, 0);
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
