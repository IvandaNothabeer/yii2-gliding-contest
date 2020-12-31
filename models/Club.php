<?php

namespace app\models;

use Yii;
use \app\models\base\Club as BaseClub;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "clubs".
*/
class Club extends BaseClub
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

	public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);

		// Use this contest as default
		$profile = \app\models\Profile::findOne(['user_id'=>yii::$app->user->identity]); 
		$profile->club_id = $this->id;
		$profile->save(false);
	}
}
