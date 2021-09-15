<?php


namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

//use app\models\Contest;
use app\models\SmsForm;



/**
 * ClubController implements the CRUD actions for Sms Interface.
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
						'actions' => ['index'],
						'roles' => ['AppContestFull'],
					],
				],
			],
		];
	}

	/**
	 * Lists all Club models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$gateway = Yii::$app->sms;

		//$messages = $gateway->receive();

		$model = new SmsForm();

		if ($model->load(Yii::$app->request->post())){
			($model->to==0) 
			? $gateway->sendSMStoAll(null, $model->message)
			: $gateway->sendSMStoOne($model->to, $model->message);
			Yii::$app->session->setFlash('success', 'Message Sent');
		}


		return $this->render('index', ['model' => $model,]);
	}

	/**
	 * Displays a single Club model.
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id)
	{

	}
}
