<?php

namespace app\models;

use Yii;
use \app\models\base\Pilot as BasePilot;
use yii\helpers\ArrayHelper;
use \app\models\Status;

/**
* This is the model class for table "pilots".
*/
class Pilot extends BasePilot
{

	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				# custom behaviors
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
		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();

		if (\Yii::$app->user->isGuest){
			$contest = 0;	
		}
		else{
			$contest = \yii::$app->user->identity->profile->contest_id;
		}

		return parent::find()->andWhere(['pilots.contest_id' => $contest]);

	}

	public static function findEvery()
	{
		return parent::find();
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getStatus()
	{
		return $this->hasOne(\app\models\Status::class, ['pilot_id' => 'id']);
	}

	public function afterSave($insert, $changedAttributes)
	{

		$status = Status::findOne(['pilot_id'=>$this->id]) ?? new Status;
		$status->pilot_id = $this->id;
		$status->save();

		return parent::afterSave($insert, $changedAttributes);


	}

	public function beforeDelete()
	{
		$status = Status::findOne(['pilot_id'=>$this->id]);
		if ($status) $status->delete();
		return parent::beforeDelete();

	}


}
