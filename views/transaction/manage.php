<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\MultipleInput;
use yii\widgets\Pjax;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Item $models
*/

$this->title = Yii::t('models', 'Transaction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Transaction'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Manage';
?>
<div class="giiant-crud item-update">

	<h1>
		<?= Yii::t('models', 'Account Transactions') ?>
	</h1>

	<hr />

	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>


	<?php $form = ActiveForm::begin([

	]); ?>

	<!-- Prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>

	<div class="row justify-content-center align-items-top">
		<div class="col-md-6">
			<?= Html::label('Person') ?>
			<?= Html::dropDownList('person_id', $person_id, yii\helpers\ArrayHelper::map(app\models\Person::find()->all(), 'id', 'name'),
				[
					'id'=>'person',
					'class'=>'form-control',
			])
			?>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<h2></h2>
				<?= Html::submitButton('Confirm and Update Account', ['class' => 'btn btn-success']); ?>
				<?= Html::a(
					'<span class="glyphicon glyphicon-copy"></span> ' . 'Prepare Invoice',
					['report', 'person_id' => $person_id],
					['class' => 'btn btn-primary']
				) ?>
				<?= Html::a(
					'<span class="glyphicon glyphicon-envelope"></span> ' . 'Email Invoice',
					['report', 'person_id' => $person_id, 'sendmail'=>'true'],
					['class' => 'btn btn-warning']
				) ?>
			</div>
		</div>
	</div>

	<div class="row justify-content-center align-items-top">
		<div class=panel-body>
			<?php 
			echo TabularInput::widget([
				'id'						=>'t0',
				'models'					=> $models,
				'addButtonPosition'			=> TabularInput::POS_FOOTER,
				//'cloneButton'				=> true,
				'modelClass'				=> \app\models\Transaction::class,
				'min'						=> 0,
				'allowEmptyList'			=> true,
				'form'						=> $form,
				'rowOptions' => [
					'id' => 'row{multiple_index_t0}',
				],
				'attributeOptions' => [
					'min'						=> 0,
					'enableAjaxValidation'      => false,
					'enableClientValidation'    => true,
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
						'name' => 'person_id',
						'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
						'defaultValue' => $person_id,
					],
					[
						'name'  => 'date',
						'title' => 'Date',
						'type'  => DatePicker::class,
						'defaultValue' => date ('Y-m-d'),
						'options' => [
							'pluginOptions' => [
								'format' => 'yyyy-m-d',
								'todayHighlight' => true
							]
						]
					],
					[
						'name'  => 'type_id',
						'title' => 'Type',
						'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
						'items' => ['0'=>''] + yii\helpers\ArrayHelper::map(app\models\TransactionType::find()->all(),'id','name'),
						'defaultValue' => null,
						'columnOptions' => [
							'style' => 'width: 15%;',
						],
						'options' => [
							'onchange' =>'
							var qty = 0; 
							$.post("get-detail?id=" + $(this).val(), function(data){
							console.log(data);
							qty = $("#quantity-{multiple_index_t0}").val();
							console.log(qty);
							$("#details-{multiple_index_t0}").val(data.detail);
							$("#item_price-{multiple_index_t0}").val(data.price);
							//$("#transaction-{multiple_index_t0}-amount-disp").val(data.price * qty);
							//$("#transaction-{multiple_index_t0}-amount").val(data.price * qty);
							$("#amount-{multiple_index_t0}-disp").val(data.price * qty);
							$("#amount-{multiple_index_t0}").val(data.price * qty);
							},"json");
							'
						]

					],
					[
						'name' => 'details',
						'title' => 'Details',
						'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
						'options' => [
							'id' => 'details-{multiple_index_t0}',
						],
						'columnOptions' => [
							'style' => 'width: 30%;',
						]
					],
					[
						'name' => 'quantity',
						'title' => 'Qty',
						'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
						'defaultValue' => 1,
						'options' => [
							'id' => 'quantity-{multiple_index_t0}',
							'type' => 'number',
							'min' => 0,
							'oninput' => '
							var price = $("#item_price-{multiple_index_t0}").val();
							var qty = $("#quantity-{multiple_index_t0}").val();
							var total = qty * price;
							//$("#transaction-{multiple_index_t0}-amount-disp").val(price * qty);
							//$("#transaction-{multiple_index_t0}-amount").val(price * qty);
							$("#amount-{multiple_index_t0}-disp").val(total);
							$("#amount-{multiple_index_t0}").val(total);
							',
						],
						'columnOptions' => [
							'style' => 'width: 7%;',
						]
					],
					[
						'name' => 'item_price',
						'title' => 'Item Price',
						'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
						'defaultValue' => 0,
						'options' => [
							'id' => 'item_price-{multiple_index_t0}',
							'type' => 'number',
							'oninput' => '
							var price = $("#item_price-{multiple_index_t0}").val();
							var qty = $("#quantity-{multiple_index_t0}").val();
							var total = qty * price; 
							//$("#transaction-{multiple_index_t0}-amount-disp").val(price * qty);
							//$("#transaction-{multiple_index_t0}-amount").val(price * qty);
							$("#amount-{multiple_index_t0}-disp").val(total);
							$("#amount-{multiple_index_t0}").val(total);
							',
						],
						'columnOptions' => [
							'style' => 'width: 15%;',
						]
					],
					[
						'name' => 'amount',
						'title' => 'Total Price',
						'type' =>  NumberControl::class,
						'defaultValue' => 0,
						'options' => [
							'id' => 'amount-{multiple_index_t0}',
							'maskedInputOptions' => [
								'prefix' => '$ ',
								//'suffix' => ' ¢',
								'allowMinus' => true
							],
						],
						'columnOptions' => [
							'style' => 'width: 15%;',
						]
					],
				],
			]);

			?>

		</div>

		<?= Html::submitButton('Confirm and Update Account', ['class' => 'btn btn-success']); ?>

	</div>
	<?php   
	ActiveForm::end();

	\yii\widgets\Pjax::end(); 

	?>

</div>

<?php JSRegister::begin(); ?>
<script>

	$("#person").on('change', function(){
		var person  = $("#person").val();
		location.href = "manage?person_id="+person;
	});

</script>
<?php JSRegister::end(); ?>