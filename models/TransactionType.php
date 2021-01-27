<?php

namespace app\models;

use Yii;
use \app\models\base\TransactionType as BaseTransactionType;
use yii\helpers\ArrayHelper;
use kartik\builder\TabularForm;
use kartik\grid\GridView;

/**
* This is the model class for table "items".
*/
class TransactionType extends BaseTransactionType
{

	public $table;  // used for Multi Input Widget

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

	public static function find(){

		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();

		if (\Yii::$app->user->isGuest){
			$contest = 0;	
		}
		else{
			$contest = \yii::$app->user->identity->profile->contest_id;
		}
		return parent::find()->andWhere(['contest_id' => $contest]);
		//return parent::find();
	}

	public function beforeDelete()
	{
		if ($this->name == 'LAUNCH' || $this->name == 'RETRIEVE') return false;
		return parent::beforeDelete();
	}

}
