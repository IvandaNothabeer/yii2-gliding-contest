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
			<?= Html::label('Pilot') ?>
			<?= Html::dropDownList('pilot_id', $pilot_id, yii\helpers\ArrayHelper::map(app\models\Pilot::find()->all(), 'id', 'name'),
				[
					'id'=>'pilot',
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
					['report', 'pilot_id' => $pilot_id],
					['class' => 'btn btn-primary']
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
				'modelClass'				=> \app\models\Transaction::className(),
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
						'name' => 'pilot_id',
						'type' =>  \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
						'defaultValue' => $pilot_id,
					],
					[
						'name'  => 'date',
						'title' => 'Date',
						'type'  => DatePicker::className(),
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
							$("#transaction-{multiple_index_t0}-amount-disp").val(data.price * qty);
							$("#transaction-{multiple_index_t0}-amount").val(data.price * qty);
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
							'onchange' => '
							var price = $("#item_price-{multiple_index_t0}").val();
							var qty = $("#quantity-{multiple_index_t0}").val(); 
							$("#transaction-{multiple_index_t0}-amount-disp").val(price * qty);
							$("#transaction-{multiple_index_t0}-amount").val(price * qty);
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
							'onchange' => '
							var price = $("#item_price-{multiple_index_t0}").val();
							var qty = $("#quantity-{multiple_index_t0}").val(); 
							$("#transaction-{multiple_index_t0}-amount-disp").val(price * qty);
							$("#transaction-{multiple_index_t0}-amount").val(price * qty);
							',
						],
						'columnOptions' => [
							'style' => 'width: 15%;',
						]
					],
					[
						'name' => 'amount',
						'title' => 'Total Price',
						'type' =>  NumberControl::className(),
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

	$("#pilot").on('change', function(){
		var pilot  = $("#pilot").val();
		location.href = "manage?pilot_id="+pilot;
	});

</script>
<?php JSRegister::end(); ?>