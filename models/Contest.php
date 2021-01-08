<?php

namespace app\models;

use Yii;
use \app\models\base\Contest as BaseContest;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "contests".
*/
class Contest extends BaseContest
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
		
		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();
			
		if (\Yii::$app->user->isGuest){
			$club = 0;	
		}
		else{
			$club = \yii::$app->user->identity->profile->club_id;
		}
			  
		return parent::find()->andWhere(['club_id' => $club]);
		
		//return parent::find();
	}

	public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);

		// Use this contest as default
		$profile = \app\models\Profile::findOne(['user_id'=>yii::$app->user->identity]); 
		$profile->contest_id = $this->id;
		$profile->save(false);

		// Create Default Contest Prices
		if ($insert)

		{
			$defaultTypes = \app\models\DefaultType::find()->all();
			foreach ($defaultTypes as $defaultType)
			{
				$type = new \app\models\TransactionType();
				$type->contest_id = $this->id;
				$type->name = $defaultType->name;
				$type->description = $defaultType->description;
				$type->price = $defaultType->price;
				$type->credit = $defaultType->credit;
				$type->save(false);
			}
		}

		// make the uploads directory

		@mkdir("/var/sftp/igcfiles/$this->igcfiles", 0777, true);

	}

	public static function findEvery()
	{
		return parent::find();	
	}

}
