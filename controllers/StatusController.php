<?php

namespace app\controllers;

use app\models\Status;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use kartik\grid\EditableColumnAction;
use app\models\search\Status as StatusSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

use yii;


/**
* This is the class for controller "StatusController".
*/
class StatusController extends \app\controllers\base\StatusController
{


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
							'actions' => ['editstatus', 'reset-grid', 'manage'],
							'roles' => ['AppStatustEdit', 'AppStatusFull']
						],
					],
				],
			]
		);

	}

	public function actions()
	{
		return ArrayHelper::merge(parent::actions(), [
			'editstatus' => [                                       // identifier for your editable action
				'class' => EditableColumnAction::className(),     	// action class name
				'modelClass' => Status::className(),                // the update model class
			]
		]);
	}

	public function actionResetGrid(){

		date_default_timezone_set('Pacific/Auckland');
		$statuses= Status::find()->all();
		foreach ($statuses as $status)
		{
			$status->status = 'Gridded';
			$status->date = date('Y-m-d');
			$status->time = date ('H:i:s');
			$status->save();

			$this->redirect('index');
		}

	}

	/**
	* Lists all Status models.
	* @return mixed
	*/
	public function actionManage()
	{
		$searchModel  = new StatusSearch;
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->pagination = ['pageSize' => 100];

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		if (Yii::$app->request->isPost)
		{	   
			$status= Status::findOne(Yii::$app->request->post('id'));
			$status->status = Yii::$app->request->post('status');
			$status->date = date('Y-m-d');
			$status->time = date('H:i:s');
			$status->save(false);

		}

		return $this->render('manage', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

}
