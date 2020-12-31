<?php


use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Item $models
*/

$this->title = Yii::t('models', 'Glider Tracking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Track'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Updates';
?>

<head>
	<script type="text/javascript">
		window.setTimeout(function(){ document.location.reload(true); }, 60000);
	</script>
</head>

<div class="giiant-crud item-update">

	<h1>
		<?= Yii::t('models', 'Glider Tracking Updates') ?>
	</h1>

	<div class="clearfix crud-navigation">
		<div class="pull-left">
			<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Status Updates', ['/status/manage'], ['class' => 'btn btn-success']) ?>
		</div>
		<?php
		if(\Yii::$app->user->can('app_status_create', ['route' => true])){
		?>
			<div class="pull-right">
				<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Reset All to Grid', ['status/reset-grid'], ['class' => 'btn btn-warning', 'onclick'=> 'return confirm (This Will Reset All the Gliders back to Gridded)']) ?>
			</div>
		<?php
		}
		?>
	</div>

	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>


	<?php $form = ActiveForm::begin(['method'=>'post']); ?>


	<!-- Prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>

	<div class="row justify-content-center align-items-top">
		<div class=panel-body>

			<?php
			echo TabularForm::widget([
				'dataProvider'=>$dataProvider,
				'form'=>$form,
				//'attributes'=>$model->formAttribs,
				'actionColumn'=>false,
				'checkboxColumn'=>false,
				'gridSettings'=>['condensed'=>true,
					'panel'=>[
						'before' => false,
				]],
				'attributes' =>
				[
					'rego'=>[ 
						'type'=>TabularForm::INPUT_STATIC,
						'label' => 'Aircraft',
						'value' => function ($model, $key, $index, $widget) { return $model['rego'];},
					],
					'thetime'=>[
						'type'=>TabularForm::INPUT_STATIC,
						'label' => 'Time Stamp',
						'value' => function ($model, $key, $index, $widget) {
							if (isset($model['thetime']))
							{
								date_default_timezone_set('Pacific/Auckland');
								$utc_offset =  date('Z') / 3600; 
								return date('Y-m-d H:i:s' , strtotime($utc_offset. ' hours', strtotime($model['thetime'])));
							}	
							else
							{
								return null;
							}
						},
						'options' => function ($model, $key, $index, $column) {
							if (isset($model['thetime'])){
								date_default_timezone_set('Pacific/Auckland');
								$utc_offset =  date('Z') / 3600;
								$style = [];
								$ts = date('Y-m-d H:i:s' , strtotime($utc_offset. ' hours', strtotime($model['thetime'])));
								if ($ts < date('Y-m-d H:i:s',strtotime('-1 hours'))) $style = ['style' => 'background-color:orange'];
								if ($ts < date('Y-m-d H:i:s',strtotime('-2 hours'))) $style = ['style' => 'background-color:red'];
								return $style;
							}
						},
					],
					'lat'=>[
						'type'=>TabularForm::INPUT_STATIC,
					],
					'lng'=>[
						'type'=>TabularForm::INPUT_STATIC,
						'label' => 'Long', 
					],
					'speed'=>[
						'type'=>TabularForm::INPUT_STATIC,
						'options' => function ($model, $key, $index, $column) {
							if (isset($model['speed'])){
								if ($model['speed'] < 20) $style = ['style' => 'background-color:orange'];
								return $style ?? [];
							}
						}, 
					],
					'course'=>[
						'type'=>TabularForm::INPUT_STATIC, 
					],
					'alt'=>[
						'type'=>TabularForm::INPUT_STATIC, 
						'label' => 'Altitude',
						'value' => function ($model, $key, $index, $widget) { 
							return round(@$model['alt']/0.3048);	
						}
					],
					'height'=>[
						'type' => TabularForm::INPUT_STATIC,
						'label' => 'Height',
						'value' => function ($model, $key, $index, $widget) { 
							return round((@$model['alt'] - @$model['gl'])/0.3048);	
						},
						'options' => function ($model, $key, $index, $column) {
							$height = round((@$model['alt'] - @$model['gl'])/0.3048);
							$style =[];
							if (isset($model['thetime']) and $height < 200) $style = ['style' => 'background-color:orange'];
							return $style;
						},
					],
					//'seconds_difference'=>[ 
					//	'type'=>TabularForm::INPUT_STATIC, 
					//	'label' => 'Update Interval',
					//],
					'status' => [
						'type' => TabularForm::INPUT_RAW,
						'value' => function ($model, $key, $index, $widget) {
							date_default_timezone_set('Pacific/Auckland');
							$utc_offset =  date('Z') / 3600;
							$ts = date('Y-m-d H:i:s' , strtotime($utc_offset. ' hours', strtotime(@$model['thetime']))); 
							$status = 'OK';
							if (@$model['alt']-@$model['gl'] < 10) $status = "Height";
							if (@$model['speed'] < 10) $status = 'Speed';
							if ($ts < date('Y-m-d H:i:s',strtotime('-15 mins'))) $status = 'Slow Update';
							if ($ts < date('Y-m-d H:i:s',strtotime('-2 hours'))) $status = 'No Update';
							return $status;
						}
					],
				],
			]); 
			?>
		</div>

	</div>
	<?php   
	ActiveForm::end();

	\yii\widgets\Pjax::end(); 

	?>

</div>

<?php JSRegister::begin(); ?>
<script>

	$("#dayDate").on('change', function(){
		var date  = $("#dayDate").val();
		location.href = "track?dayDate="+date;
	});

</script>
<?php JSRegister::end(); ?>
