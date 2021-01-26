<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Upload;
use yii\data\ArrayDataProvider;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\models\Contest;
use app\models\Pilot;
use app\components\igcFileHelper;

class UploadController extends Controller
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
						'actions' => ['index', 'pilot-list'],
						'allow' => true,
						//'roles' => ['?'],
					],
				],
			],
		];
	}

	public function actionIndex ($contest_id=null)
	{

		date_default_timezone_set('Pacific/Auckland');



		$model = new Upload;
		$model->date = date('Y-m-d');

		if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {


			$model->file = UploadedFile::getInstance($model, 'file');

			if ($model->file && $model->validate()) {

				$contest = Contest::findEvery()->where(['id'=>$model->contest_id])->one();

				$alphabet= array_merge(range('0','9'), range('A','Z'));
				$y = substr($model->date,3,1);
				$m = $alphabet[(int)substr($model->date,5,2)];
				$d = $alphabet[(int)substr($model->date,8,2)];

				$filename = $y . $m . $d . 'G' . $model->rego;

				$existing_files = \yii\helpers\FileHelper::findFiles("/var/sftp/igcfiles/$contest->igcfiles/", 
					[
						'only'=>["$filename*.igc"], 
						'recursive'=>FALSE, 
						'caseSensitive'=>false,
				]);

				$filenum = count($existing_files) + 1;

				$filename .=  $filenum . '.igc';

				if ($model->file->saveAs("/var/sftp/igcfiles/$contest->igcfiles/" . $filename))
				{

					\Yii::$app->getSession()->setFlash('success', "Sucess : Uploaded Contest Trace for Aircraft : $model->rego on Date : $model->date to Contest : $contest->name");
				}
				else
					\Yii::$app->getSession()->setFlash('error', 'Uh Oh: Something went wrong trying to upload file '. $filename);
			}

			return $this->redirect('upload');
		}

		return $this->render('index', ['model'=> $model]);

	}

	public function actionPilotList() {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$contest_id = $parents[0];
				$contests = ArrayHelper::map(Pilot::findEvery()->where(['contest_id'=>$contest_id])->orderBy('rego_short ASC')->all(),'id', 'rego_short');
				foreach ($contests as $key=>$value) $out[]= ['id'=>$key,'name'=>$value]; 
				return ['output'=>$out, 'selected'=>''];
			}
		}
		return ['output'=>'', 'selected'=>''];
	}

}


?>
