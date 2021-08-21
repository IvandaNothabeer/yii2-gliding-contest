<?php

namespace app\controllers;

use app\models\Retrieve;
use app\models\search\Retrieve as RetrieveSearch;
use yii\data\ActiveDataProvider; 
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

use Yii;

/**
* This is the class for controller "RetrieveController".
*/
class RetrieveController extends \app\controllers\base\RetrieveController
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
							'actions' => ['manage'],
							'roles' => ['AppRetrieveEdit', 'AppRetrieveFull']
						],
					],
				],
			]
		);

	}

	/**
	* Lists all Retrieve models for a given day.
	* @return mixed
	*/
	public function actionIndex()
	{
		$searchModel  = new RetrieveSearch;
		if (!isset(yii::$app->getRequest()->getQueryParam('Retrieve')['date'])) $searchModel->date = date('Y-m-d');
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


	public function actionManage ($retrieve_date = null, $towplane_id = null)
	{

		if (is_null($retrieve_date)) $retrieve_date = date('d-M-Y');
		if (is_null($towplane_id)) {
			$towplane = \app\models\Towplane::find()->one();
			$towplane_id = $towplane->id ?? 0;
		}

		$date = date('Y-m-d',strtotime($retrieve_date));

		$query = Retrieve::find()->where(['date'=>$date])->andWhere(['towplane_id'=>$towplane_id]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$models = $dataProvider->getModels();

		$request = Yii::$app->getRequest();
		if ($request->isPost)  {

			// Create an array of new retrieve models 
			$data = Yii::$app->request->post('Retrieve', []);
			$models = [];
			foreach (array_keys($data) as $index) {
				$models[$index] = new Retrieve();
			}


			// Delete the old Launch models, one by one so that beforeDelete can remove the transactions
			$dRetrieves = $query->all();
			foreach ($dRetrieves as $dRetrieve) $dRetrieve->delete();

			// Save the new Retrieve models
			if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
				foreach ($models as $model) {
					$model->save(false);
				}
			}
			Yii::$app->session->addFlash('success', 'Updated Aero Tow Retrieve List');
			return $this->refresh();

		}
		return $this->render('manage', ['models' => $models, 'retrieve_date' => $retrieve_date, 'towplane_id' => $towplane_id]);	
	}

}
