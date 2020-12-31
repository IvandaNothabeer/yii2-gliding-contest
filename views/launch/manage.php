<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\MultipleInput;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Item $models
*/

$this->title = Yii::t('models', 'Launch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Launch'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Manage';
?>
<div class="giiant-crud item-update">

	<h1>
		<?= Yii::t('models', 'Launches') ?>
	</h1>

	<hr />

	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	<?php $form = ActiveForm::begin(); ?>

	<!-- Prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>

	<div class="row justify-content-center align-items-top">
		<div class="col-md-6">
			<?= '<label>Launch Date</label>'; ?>
			<?= DatePicker::widget([
				'id' => 'launch_date',
				'name' => 'launch_date', 
				'value' => $launch_date,
				'options' => ['placeholder' => 'Select Launch Date ...'],
				'pluginOptions' => [
					'format' => 'dd-M-yyyy',
					'todayHighlight' => true
				],
			]);
			?>
		</div>
		<div class="col-md-6">
			<?= Html::label('Towplane') ?>
			<?= Html::dropDownList('towplane_id', $towplane_id, yii\helpers\ArrayHelper::map(app\models\Towplane::find()->all(), 'id', 'rego'),
				[
					'id'=>'towplane',
					'class'=>'form-control',
			])
			?>
		</div>
	</div>

	<div class="row justify-content-center align-items-top">

		<?php 
		echo TabularInput::widget([
			'id'						=>'multiple-input',
			'models'					=> $models,
			'addButtonPosition'			=> TabularInput::POS_FOOTER,
			'modelClass'				=> \app\models\Launch::className(),
			'min'						=> 0,
			'allowEmptyList'			=> true,
			'attributeOptions' => [
				'min'						=> 0,
				'enableAjaxValidation'      => false,
				'enableClientValidation'    => false,
				'validateOnChange'          => false,
				'validateOnSubmit'          => true,
				'validateOnBlur'            => false,
			],
			'columns' => [
				[
					'name' => 'id',
					'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
				],
				[
					'name' => 'date',
					'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
					'defaultValue' => date('Y-m-d',strtotime($launch_date)),
				],
				[
					'name'  => 'pilot_id',
					'title' => 'Name',
					'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
					'items' => yii\helpers\ArrayHelper::map(app\models\Pilot::find()->orderBy('rego_short ASC')->all(),'id','rego_short')

				],
				[
					'name' => 'towplane_id',
					'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
					'defaultValue' => $towplane_id,
				],
			],
		]);

		?>


		<?= Html::submitButton('Update', ['class' => 'btn btn-success']); ?>

	</div>
	<?php   
	ActiveForm::end();

	\yii\widgets\Pjax::end(); 

	?>

</div>

<?php JSRegister::begin(); ?>
<script>

	$("#towplane").on('change', function(){
		var date = $("#launch_date").val();
		var tow  = $("#towplane").val();
		location.href = "manage?launch_date="+date+"&towplane_id="+tow;
	});

	$("#launch_date").on('change', function(){
		var date = $("#launch_date").val();
		var tow  = $("#towplane").val();
		location.href = "manage?launch_date="+date+"&towplane_id="+tow;
	});

</script>
<?php JSRegister::end(); ?>