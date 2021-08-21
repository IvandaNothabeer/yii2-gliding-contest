<?php

namespace app\controllers;

use app\models\Contest;
use app\models\Person;
use app\models\Pilot;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use Yii;

/**
* This is the class for controller "ContestController".
*/
class ContestController extends \app\controllers\base\ContestController
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
							'actions' => ['import', 'byclub' ],
							'roles' => ['AppContestEdit', 'AppContestFull']
						],
						[
							'allow' => true,
							'actions' => ['byclub'],
							'roles' => ['@']
						],
					],
				],
			]
		);

	}

	/**
	* Creates a new Contest model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate()
	{
		$model = new Contest;

		try {
			if ($model->load($_POST)) {
				$gnz = Yii::$app->gnz->getContest($model->gnz_id);
				$model->name = $gnz['name'];
				$model->start = $gnz['start_date'];
				$model->end = $gnz['end_date'];
				if ($model->save()) return $this->redirect(['site/setup']);
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	/**
	* Imports Pilot List for a Contest
	* @param integer $id  Constest ID
	* @return mixed
	*/
	public function actionImport($id)
	{
		$gnz_id = Contest::findOne(['id'=>$id])->gnz_id;
		$pilots = Yii::$app->gnz->getPilotList($gnz_id);

		if ($pilots){
			foreach ($pilots as $pilot){
				$model = Person::find()->joinWith(['pilots'])->where(['persons.contest_id'=>$id, 'pilots.gnz_id'=>$pilot['gnz_id']])->one();
				if (!$model){
					$model = new Person;
					$model->attributes = $pilot;
					$model->role = Person::ROLE_PILOT;
					$model->contest_id = $id;
					if (!$model->save()){
						foreach($model->errors as $e) \Yii::$app->session->addFlash('error', "$model->name : ". implode(' ',$e));	
					}
					else{
						$person_id = $model->id;
						$model = new Pilot;
						$model->attributes = $pilot;
						$model->person_id = $person_id;
						$model->contest_id = $id;
						if (!$model->save()){
							foreach($model->errors as $e) \Yii::$app->session->addFlash('error', "$model->rego : ". implode(' ',$e));	
						}	
					}
				}
			}
		}

		return $this->redirect(Url::previous());

	}

	public function actionByclub() {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$club_id = $parents[0];
				$contests = Yii\helpers\ArrayHelper::map(Contest::findEvery()->where(['club_id'=>$club_id])->all(),'id', 'name');
				foreach ($contests as $key=>$value) $out[]= ['id'=>$key,'name'=>$value]; 
				return ['output'=>$out, 'selected'=>''];
			}
		}
		return ['output'=>'', 'selected'=>''];
	}
}   	

