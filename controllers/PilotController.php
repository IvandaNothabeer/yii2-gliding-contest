<?php

namespace app\controllers;

use app\models\Pilot;
use app\models\Contest;
use app\models\search\Pilot as PilotSearch;
use yii\data\ActiveDataProvider; 
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii;

/**
* This is the class for controller "PilotController".
*/
class PilotController extends \app\controllers\base\PilotController
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
							'actions' => ['report'],
							'roles' => ['AppPilotView', 'AppPilotEdit', 'AppPilotFull']
						],
					],
				],
			]
		);

	}

	public function actionReport() {


		$contest = Contest::findOne(['id'=>yii::$app->user->identity->profile->contest_id]);

		$query = Pilot::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => false,
			'sort'=> ['defaultOrder' => ['rego_short' => SORT_ASC]],
		]);
		$models = $dataProvider->getModels();
		$searchModel  = new PilotSearch;

		// get your HTML raw content without any layouts or scripts
		//$content = $this->renderPartial('manage', ['models' => $models, 'pilot_id' => $pilot_id]);
		$content =   $this->renderPartial('_report', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'contest' => $contest,
		]);	

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE, 
			// A4 paper format
			'format' => Pdf::FORMAT_A4, 
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
