<?php

namespace app\models;

use Yii;
use \app\models\base\Status as BaseStatus;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "status".
*/
class Status extends BaseStatus
{

	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				# custom behaviors
				'sammaye\audittrail\LoggableBehavior'
			]
		);
	}

	public function rules()
	{
		return ArrayHelper::merge(
			parent::rules(),
			[
				# custom validation rules
			]
		);
	}

	public static function find()
	{

		$pilots = \yii\helpers\ArrayHelper::getColumn(\app\models\Pilot::find()->asArray()->all(),'id');
		return parent::find()->andWhere(['pilot_id' => $pilots]);

	}

	public static function findEvery()
	{
		return parent::find();
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPilot()
	{
		return $this->hasOne(\app\models\Pilot::class, ['id' => 'pilot_id']);
	}
}
