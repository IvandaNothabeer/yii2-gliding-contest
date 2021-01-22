<?php

namespace app\controllers;

use app\models\Launch;
use app\models\search\Launch as LaunchSearch;
use yii\data\ActiveDataProvider; 
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use kartik\mpdf\Pdf;
use app\models\Towplane;
use app\models\Contest;
use app\models\Club;



use Yii;


/**
* This is the class for controller "LaunchController".
*/
class LaunchController extends \app\controllers\base\LaunchController
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
							'actions' => ['manage', 'report', 'launches', 'add-launch', 'remove-launch'],
							'roles' => ['AppLaunchEdit', 'AppLaunchFull']
						],
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
		$searchModel  = new LaunchSearch;
		if (!isset(yii::$app->getRequest()->getQueryParam('Launch')['date'])) $searchModel->date = date('Y-m-d');
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

	/**
	* Creates a new Launch model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate()
	{
		$model = new Launch;

		try {
			if ($model->load($_POST) && $model->save()) {
				Yii::$app->session->setFlash('success', $model->pilot->rego_short.' Launched Behind '.$model->towplane->rego);
				if ($model->date==date('Y-m-d'))
				{
					$status = \app\models\Status::findOne(['pilot_id'=>$model->pilot]);
					$status->status = \app\models\Status::STATUS_LAUNCHED;
					$status->save(false);
				}
				return $this->redirect(['create', 'model' => new Launch]);
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	public function actionManage ($launch_date = null, $towplane_id = null)
	{

		if (is_null($launch_date)) $launch_date = date('d-M-Y');
		if (is_null($towplane_id)) {
			$towplane = \app\models\Towplane::find()->one();
			$towplane_id = $towplane->id ?? 0;
		}

		$date = date('Y-m-d',strtotime($launch_date));

		$query = Launch::find()->with('pilot')->where(['date'=>$date])->andWhere(['towplane_id'=>$towplane_id]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$models = $dataProvider->getModels();

		$request = Yii::$app->getRequest();
		if ($request->isPost)  {

			// Create an array of new launch models 
			$data = Yii::$app->request->post('Launch', []);
			$models = [];
			foreach (array_keys($data) as $index) {
				$models[$index] = new Launch();
			}

			// Delete the old Launch models, one by one so that beforeDelete can remove the transactions
			$dLaunches = $query->all();
			foreach ($dLaunches as $dLaunch) $dLaunch->delete();

			// Save the new Launch models
			if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
				foreach ($models as $model) {
					$model->save(false);
				}
			}
			Yii::$app->session->addFlash('success', 'Updated Contest Launch List');
			return $this->refresh();

		}
		return $this->render('manage', ['models' => $models, 'launch_date' => $launch_date, 'towplane_id' => $towplane_id]);	
	}

	public function actionReport($towplane_id) 
	{

		$towplane =  Towplane::findOne(['id'=>$towplane_id]);
		if ($towplane === null) {
			throw new \yii\web\NotFoundHttpException;

		}
		$contest = Contest::findOne(['id'=>yii::$app->user->identity->profile->contest_id]);
		$club = Club::findOne(['id'=>yii::$app->user->identity->profile->club_id]);

		$searchModel  = new LaunchSearch;

		$query = Launch::find()->where(['towplane_id'=>$towplane_id]);
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

	public function actionLaunches($date = null)
	{
		!is_null($date) ?: $date = date('Y-m-d');
		$pilots = \app\models\Pilot::find()->orderBy('rego_short')->all();
		$towplanes = \app\models\Towplane::find()->all();
		$launches = Launch::findAll(['date'=>$date]);
		return $this->render('launches', ['date' => $date, 'pilots' => $pilots , 'towplanes' => $towplanes, 'launches' => $launches]);
	}

	public function actionAddLaunch ($towplane, $pilot)
	{
		$launch = new Launch;
		$launch->towplane_id = $towplane;
		$launch->pilot_id = $pilot;
		$launch->date = date('Y-m-d');

		$status = \app\models\Status::findOne(['pilot_id'=>$pilot]);
		$status->status = \app\models\Status::STATUS_LAUNCHED;
		$status->save(false);

		return $launch->save();	
	}

	public function actionRemoveLaunch ($towplane, $pilot)
	{
		$launch = Launch::findOne(['towplane_id'=>$towplane, 'pilot_id'=>$pilot, 'date'=>date('Y-m-d')]);
		return $launch->delete();	
	}


}
