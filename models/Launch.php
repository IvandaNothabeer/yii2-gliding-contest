<?php

namespace app\models;

use Yii;
use \app\models\base\Launch as BaseLaunch;
use yii\helpers\ArrayHelper;
use app\models\Transaction;
use app\models\Pilot;

/**
* This is the model class for table "launches".
*/
class Launch extends BaseLaunch
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

	public function beforeSave($insert)
	{
		parent::beforeSave($insert);

		if ($insert)
			$transaction = new Transaction();
		else
			$transaction = Transaction::findOne(['id'=>$this->transaction_id]);

		$code = \app\models\TransactionType::findOne(['name'=>'LAUNCH']);

		if ($code){
			$transaction->pilot_id = $this->pilot_id;	
			$transaction->type_id = $code->id;
			$transaction->details = $code->description;
			$transaction->quantity = 1;
			$transaction->item_price = $code->price;
			$transaction->amount = $code->price;
			$transaction->date = $this->date;
			$transaction->save(false);
			$this->transaction_id = $transaction->id;
		}
		return true;

	}

	public function beforeDelete()
	{
		parent::beforeDelete();
		$transaction = Transaction::findOne(['id'=>$this->transaction_id]);
		if ($transaction) $transaction->delete();
		return true;

	}

	public static function find(){

		$pilots = \yii\helpers\ArrayHelper::getColumn(Pilot::find()->asArray()->all(),'id');
		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();
		//if (!\Yii::$app->user->can('Administrator')) 
		return parent::find()->andWhere(['pilot_id' => $pilots]);
		//return parent::find();
	}

}
