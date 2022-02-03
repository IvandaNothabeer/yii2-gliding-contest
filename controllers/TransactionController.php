<?php

namespace app\controllers;

use app\models\Transaction;
use app\models\TransactionType;
use app\models\Person;
use app\models\Contest;
use app\models\Club;
use app\models\search\Transaction as TransactionSearch;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\web\Response;
use yii\widgets\ActiveForm;





use Yii;

/**
 * This is the class for controller "TransactionController".
 */
class TransactionController extends \app\controllers\base\TransactionController
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
							'actions' => ['manage', 'table', 'report', 'batch-update', 'setup'],
							'roles' => ['AppTransactionEdit', 'AppTransactionFull']
						],
						[
							'allow' => true,
							'actions' => ['get-detail'],
							'roles' => ['@']
						],
					],
				],
			]
		);
	}

	public function actionManage($person_id = null)
	{

		if (is_null($person_id)) {
			$person = \app\models\Person::find()->one();
			$person_id = $person->id ?? 0;
		}

		$query = Transaction::find()->where(['person_id' => $person_id]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => false,
		]);
		$models = $dataProvider->getModels();

		$request = Yii::$app->getRequest();
		if ($request->isPost) {

			// Create an array of new launch models 
			$data = Yii::$app->request->post('Transaction', []);
			$models = [];
			foreach (array_keys($data) as $index) {
				$models[$index] = new Transaction();
			}

			// Save the new Transaction models
			if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
				Transaction::deleteAll('person_id=' . $person_id);
				foreach ($models as $model) {
					$model->save(true);
				}
				Yii::$app->session->addFlash('success', 'Updated Transaction List');
				return $this->refresh();
			} else {
				if (empty(Yii::$app->request->post('Transaction', []))) {
					Transaction::deleteAll('person_id=' . $person_id);
					Yii::$app->session->addFlash('success', 'Removed All Transactions');
					return $this->refresh();
				}
			}
		}

		return $this->render('manage', ['models' => $models, 'person_id' => $person_id]);
	}

	public function actionSetup($contest_id = null)
	{

		$persons = Person::find()->all();
		$types = TransactionType::find()->andWhere(['credit' => 'Debit'])->andWhere(['not in', 'name', ['RETRIEVE', 'LAUNCH']])->all();

		foreach ($persons as $person) {
			$transactions = ArrayHelper::getColumn($person->transactions, 'type_id');
			foreach ($types as $type) {
				if (!in_array($type->id, $transactions)) {
					$new = new Transaction;
					$new->person_id = $person->id;
					$new->type_id = $type->id;
					$new->date = date('Y-m-d');
					$new->details = $type->description;
					$new->quantity = 0;
					$new->item_price = $type->price;
					$new->amount = 0;
					$new->save(false);
				}
			}
		}

		return $this->redirect(Yii::$app->request->referrer);
	}

	public function actionReport($person_id, $sendmail = false)
	{

		$person =  Person::findOne(['id' => $person_id]);
		if ($person === null) {
			throw new \yii\web\NotFoundHttpException;
		}
		$contest = Contest::findOne(['id' => yii::$app->user->identity->profile->contest_id]);
		$club = Club::findOne(['id' => yii::$app->user->identity->profile->club_id]);

		$searchModel  = new TransactionSearch;

		$query = Transaction::find()->where(['person_id' => $person_id]);
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
			'person' => $person,
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
				'SetHeader' => [$contest->name],
				'SetFooter' => ['{PAGENO}'],
			]
		]);

		// return the pdf output as per the destination setting
		if ($sendmail) {
			$fileName = Yii::getAlias('@runtime/' . $contest->name . '.pdf');
			$pdf->destination = pdf::DEST_FILE;
			$pdf->filename = $fileName;

			Yii::$app->mailer->compose()
				->setFrom(\Yii::$app->params['senderEmail'])
				->setTo($person->email)
				->setSubject("Contest Invoice for $contest->name")
				->setTextBody('Please find your invoice Attached')
				->setHtmlBody('<b>Please find your invoice attached</b>')
				->attach($fileName)
				->send();

				Yii::$app->session->addFlash('success', "Account Has been Sent to $person->email");
				$this->redirect(['manage','person_id' => $person_id]);

		}
		return $pdf->render();
	}

	public function actionGetDetail($id)
	{
		$detail = TransactionType::find()->where(['id' => $id])->one() ?: new TransactionType;
		return json_encode(['detail' => $detail->description, 'price' => $detail->price]);
	}
}
