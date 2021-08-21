<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "TransactionController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TransactionController extends \yii\rest\ActiveController
{
	public $modelClass = '\app\models\Transaction';


	/**
	* @inheritdoc
	*/
	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::class,
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
