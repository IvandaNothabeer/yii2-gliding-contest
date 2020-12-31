<?php

namespace app\controllers;

use app\models\Landout;
use app\models\search\LandoutSearch as LandoutSearch;
use yii\data\ActiveDataProvider; 
use yii\base\Model;
use app\models\Pilot;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use dmstr\bootstrap\Tabs;

use yii;


/**
* This is the class for controller "LandoutController".
*/
class LandoutController extends \app\controllers\base\LandoutController
{


	public $waypointList;

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
							'actions' => ['pilot', 'get-all', 'waypoint', 'report'],
							'roles' => ['@']
						],
						//[
						//	'allow'=> true,
						//	'actions'=>['index']
						//]
					],
				],
			]
		);

	}

	/**
	* Lists all Launch models for a given day.
	* @return mixed
	*/
	public function actionIndex()
	{
		$searchModel  = new LandoutSearch;
		if (!isset(yii::$app->getRequest()->getQueryParam('Landout')['date'])) $searchModel->date = date('Y-m-d');
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->pagination = ['pageSize' => 12];

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	public function actionPilot($id)
	{
		return $this->asJson(Pilot::findOne($id));
	}

	public function actionGetAll($date)
	{ 
		return $this->asJson(ArrayHelper::toArray(Landout::findAll(['date'=>$date]),['app\models\Landout' => ['lat'=>'lat','lon'=>'lng', 'rego' => 'pilot.rego_short']]));
	}

	public function actionWaypoint($id)
	{
		$wp = Yii::$app->gnz->getWaypointDetails($id);
		$wp['lat'] = substr_replace($wp['lat'], ':', 3, 0);
		$wp['long'] = substr_replace($wp['long'], ':', 3, 0);
		return $this->asJson($wp);

	}

	public function actionReport($id) {



		// get your HTML raw content without any layouts or scripts
		//$content = $this->renderPartial('manage', ['models' => $models, 'pilot_id' => $pilot_id]);
		$content = $this->renderPartial('_report', [
			'model' => Landout::find()->with('pilot')->where(['id'=>$id])->one(),
		]);


		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_UTF8, 
			// A4 paper format
			'format' => Pdf::FORMAT_A4, 
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE, 
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
			//'options' => ['title' => $contest->name],
			// call mPDF methods on the fly
			'methods' => [ 
				//'SetHeader'=>[$contest->name], 
				'SetFooter'=>['{PAGENO}'],
			]
		]);

		// return the pdf output as per the destination setting
		return $pdf->render(); 
	}


}
