<?php

namespace app\models;

use Yii;
use \app\models\base\Transaction as BaseTransaction;
use yii\helpers\ArrayHelper;

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;

/**
* This is the model class for table "transactions".
*/
class Transaction extends BaseTransaction
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

	public static function find(){

		$persons = \yii\helpers\ArrayHelper::getColumn(\app\models\Person::find()->asArray()->all(),'id');
		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();
		//if (!\Yii::$app->user->can('Administrator')) 
		return parent::find()->andWhere(['person_id' => $persons]);
		//return parent::find();
	}

}
