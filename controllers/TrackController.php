<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Track;
use yii\data\ArrayDataProvider;

class TrackController extends Controller
{

	/**
	* {@inheritdoc}
	*/
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionIndex ($dayDate=null, $contest_id=null)
	{
		if (!$dayDate)  $dayDate = date('Ymd');
		if (!$contest_id){
			if (yii::$app->user->identity)
			{
				$contest = \app\models\Contest::findOne(['id'=>yii::$app->user->identity->profile->contest_id]);
				$contest_id = $contest->id ?? 0;
			}
			else {
				$contest_id = 0;
			}
		}; 
		$tracks = Yii::$app->gnz->getContestTracks($dayDate, $contest_id);

		$dataProvider = new ArrayDataProvider([
			'allModels' => $tracks,
			'sort' => [
				'attributes' => ['rego','thetime', 'lat', 'lng','speed', 'course', 'alt', 'height', 'status'],
			],
			'pagination' => [
				'pageSize' => 100,
			],
		]);

		return $this->render('index',['dataProvider'=> $dataProvider, 'model' =>new Track, 'dayDate' => $dayDate]);

	}

}


?>
