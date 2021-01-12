<?php


namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use app\models\Contest;

use yii;
 
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
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'synch-sms'],
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

		$smsContactList = \Yii::$app->sms->getLists();
		
		$dataProvider = new ArrayDataProvider([
			'allModels' => $smsContactList,
			// Might need this too... (assuming number is unique identifier)
			'key' => 'list_id',
			// Setup sorting if not using default
			'sort' => [
				'attributes' => ['number', 'name'],
			],
			// Set pagination if not using default
			'pagination' => [
				'pageSize' => 10,
			],
		]);


		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	* Displays a single Club model.
	* @param integer $id
	*
	* @return mixed
	*/
	public function actionView($id)
	{

		$smsContactList = \Yii::$app->sms->getContacts($id);
		
		$dataProvider = new ArrayDataProvider([
			'allModels' => $smsContactList,
			// Might need this too... (assuming number is unique identifier)
			'key' => 'contact_id',
			// Setup sorting if not using default
			'sort' => [
				'attributes' => ['number', 'name'],
			],
			// Set pagination if not using default
			'pagination' => [
				'pageSize' => 10,
			],
		]);


		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('view', [
			'dataProvider' => $dataProvider,
		]);
		
	}

    public function actionSynchSms($contest_id)
    {
    	
    	$contest = Contest::findOne(['id'=>$contest_id]);
		$pilots = ArrayHelper::map($contest->pilots, 'name', 'telephone');
		$people = ArrayHelper::map($contest->people, 'name', 'telephone');
		$contacts = array_merge($pilots,$people);
		    	
		$list_id = Yii::$app->sms->createList($contest->name);
		Yii::$app->sms->createContacts($list_id, $contacts);
		
		$this->redirect(['view', 'id'=>$list_id]);

    }
}

