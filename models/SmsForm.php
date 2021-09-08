<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * SmsForm is the model behind the sms form.
 */
class SmsForm extends Model
{

	public $to;
	public $message;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// to and message are required
			[['to', 'message'], 'required'],
			['message', 'string', 'max'=> 160]
		];
	}

	/**
	 * @return array customized attribute labels
	 */
	public function attributeLabels()
	{
		return [
			'to' => 'Send To',
			'message' => 'Message'
		];
	}
}
