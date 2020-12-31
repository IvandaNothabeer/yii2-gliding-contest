<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "PilotController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class PilotController extends \yii\rest\ActiveController
{
	public $modelClass = '\app\models\Pilot';

	/**
	* @inheritdoc
	*/
	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'allow' => true,
							'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
						]
					]
				]
			]
		);
	}
}
