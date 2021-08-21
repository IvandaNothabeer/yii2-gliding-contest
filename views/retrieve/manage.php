<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\MultipleInput;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Item $models
*/

$this->title = Yii::t('models', 'Retrieve');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Retrieve'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Manage';
?>
<div class="giiant-crud item-update">

	<h1>
		<?= Yii::t('models', 'Aero Tow Retrieves') ?>
	</h1>

	<hr />

	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>


	<?php $form = ActiveForm::begin(); ?>

	<!-- Prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>

	<div class="row justify-content-center align-items-top">
		<div class="col-md-6">
			<?= '<label>Retrieve Date</label>'; ?>
			<?= DatePicker::widget([
				'id' => 'retrieve_date',
				'name' => 'retrieve_date', 
				'value' => $retrieve_date,
				'options' => ['placeholder' => 'Select Retrieve Date ...'],
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
			'modelClass'				=> \app\models\Retrieve::class,
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
					'defaultValue' => date('Y-m-d',strtotime($retrieve_date)),
				],
				[
					'name'  => 'pilot_id',
					'title' => 'Name',
					'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
					'items' => yii\helpers\ArrayHelper::map(app\models\Pilot::find()->orderBy('rego_short ASC')->all(),'id','rego_short'),
					'columnOptions' => [
						'style' => 'width: 33%;',
					]
				],
				[
					'name' => 'duration',
					'title' => 'Duration (Mins)',
					'type' =>  NumberControl::class,
					'defaultValue' => 0,
					'options' => [
						'maskedInputOptions' => [
							'digits' => 0,
							'min' => 0,
							'max' => 600,
						],
					],
				],
				[
					'name' => 'price',
					'title' => 'Cost',
					'type' =>  NumberControl::class,
					'defaultValue' => 0,
					'options' => [
						'maskedInputOptions' => [
							'prefix' => '$ ',
							//'suffix' => ' ¢',
							'allowMinus' => false
						],
					],
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
		var date = $("#retrieve_date").val();
		var tow  = $("#towplane").val();
		location.href = "manage?retrieve_date="+date+"&towplane_id="+tow;
	});

	$("#retrieve_date").on('change', function(){
		var date = $("#retrieve_date").val();
		var tow  = $("#towplane").val();
		location.href = "manage?retrieve_date="+date+"&towplane_id="+tow;
	});

</script>
<?php JSRegister::end(); ?>