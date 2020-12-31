<?php

namespace app\models;

use Yii;
use \app\models\base\Towplane as BaseTowplane;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "towplanes".
*/
class Towplane extends BaseTowplane
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
		//if (!\Yii::$app->user->can('Administrator')) 
		return parent::find()->andWhere(['contest_id' => \yii::$app->user->identity->profile->contest_id]);
		//return parent::find();
	}
}
