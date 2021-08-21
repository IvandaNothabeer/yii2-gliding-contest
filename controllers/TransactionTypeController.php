<?php

namespace app\controllers;

use app\models\TransactionType;
use app\models\search\TransactionType as TransactionTypeSearch;
use yii\data\ActiveDataProvider; 
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use Yii;
	    
/**
* This is the class for controller "TransactionTypeController".
*/
class TransactionTypeController extends \app\controllers\base\TransactionTypeController
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
							'roles' => ['AppTransactionTypeEdit', 'AppTransactionTypeFull']
						],
					],
				],
			]
		);

	}
	
    public function actionManage()
    {
		$model = new TransactionType;
		$query = TransactionType::find()->indexBy('id'); // where `id` is your primary key
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
        $models = $dataProvider->getModels();
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $count = 0;
            foreach ($models as $index => $model) {
                // populate and save records for each model
                if ($model->save()) {
                    $count++;
                }
            }
            //Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            return $this->redirect(['manage']); // redirect to your next desired page
        } else {
            return $this->render('manage', [
                'model'=>$model,
                'dataProvider'=>$dataProvider
            ]);
        }
    }
}
