<?php


namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

use app\models\SmsForm;
use app\models\Sms;
use app\models\search\Sms as SmsSearch;


/**
 * SmsController implements the CRUD actions for Sms Interface.
 */
class SmsController extends Controller
{

	/**
	 * @var boolean whether to enable CSRF validation for the actions in this controller.
	 * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	 */
	public $enableCsrfValidation = false;

	/**
	 * @inheritdoc
	 */

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'delete'],
						'roles' => ['AppContestFull'],
					],
				],
			],
		];
	}

	/**
	 * Send an SMS Message.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$gateway = Yii::$app->sms;

		$model = new SmsForm();

		$sms = new Sms();
		$searchModel  = new SmsSearch;
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->pagination = ['pageSize' => 12];

		if ($model->load(Yii::$app->request->post())) {
			($model->to == 0)
				? $gateway->sendSMStoAll(null, $model->message)
				: $gateway->sendSMStoOne($model->to, $model->message);
			Yii::$app->session->setFlash('success', 'Message Sent');
		}


		return $this->render('index', ['model' => $model, 'sms' => $sms, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
	}

	/**
	 * View Received Messages.
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id)
	{
		\Yii::$app->session['__crudReturnUrl'] = Url::previous();
		Url::remember();
		Tabs::rememberActiveState();

		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionDelete($id)
	{
		try {
			$this->findModel($id)->delete();
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		$this->redirect(['index']);
	}

	protected function findModel($id)
	{
		if (($model = Sms::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
