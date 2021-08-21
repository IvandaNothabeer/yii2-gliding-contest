<?php


namespace app\controllers;


use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider; 

use app\models\Towplane;
use app\models\Contest;
use app\models\Club;
use app\models\Launch;
use app\models\search\Launch as LaunchSearch;

use dmstr\bootstrap\Tabs;
use kartik\mpdf\Pdf;

use yii;

/**
* This is the class for controller "TowplaneController".
*/
class TowplaneController extends \app\controllers\base\TowplaneController
{

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
							'actions' => ['manage', 'report'],
							'roles' => ['AppTowplaneEdit', 'AppTowplaneFull']
						],
					],
				],
			]
		);

	}
	public function actionReport($id) 
	{

		$towplane =  Towplane::findOne(['id'=>$id]);
		if ($towplane === null) {
			throw new \yii\web\NotFoundHttpException;

		}
		$contest = Contest::findOne(['id'=>yii::$app->user->identity->profile->contest_id]);
		$club = Club::findOne(['id'=>yii::$app->user->identity->profile->club_id]);

		$searchModel  = new LaunchSearch;

		$query = Launch::find()->where(['towplane_id'=>$id]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => false,
		]);
		$models = $dataProvider->getModels();

		// get your HTML raw content without any layouts or scripts
		//$content = $this->renderPartial('manage', ['models' => $models, 'pilot_id' => $pilot_id]);
		$content =   $this->renderPartial('_report', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'towplane' => $towplane,
			'contest' => $contest,
			'club' => $club,
		]);	

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE, 
			// A4 paper format
			'format' => Pdf::FORMAT_A3, 
			// portrait orientation
			'orientation' => Pdf::ORIENT_PORTRAIT, 
			// stream to browser inline
			'destination' => Pdf::DEST_BROWSER, 
			// your html content input
			'content' => $content,  
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting 
			'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}', 
			// set mPDF properties on the fly
			'options' => ['title' => $contest->name],
			// call mPDF methods on the fly
			'methods' => [ 
				'SetHeader'=>[$contest->name], 
				'SetFooter'=>['{PAGENO}'],
			]
		]);

		// return the pdf output as per the destination setting
		return $pdf->render(); 
	}

}
