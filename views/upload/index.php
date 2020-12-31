<?php


use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Item $models
*/

$this->title = Yii::t('models', 'Contest Trace File Upload');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Upload'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'IGC File';
?>


<div class="giiant-crud item-update">

	<h1>
		<?= Yii::t('models', 'Upload Contest Trace File') ?>
	</h1>

	<hr />

	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>


	<?php $form = ActiveForm::begin(['method'=>'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>


	<!-- Prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>

	<div class="row justify-content-center align-items-top">
		<div class=panel-body>

			<?= $form->field($model, 'date')->widget(DatePicker::className(), 
				[
					'type' => DatePicker::TYPE_COMPONENT_PREPEND,
					'pluginOptions' => [
						'todayHighlight' => true,
						'todayBtn' => true,
						'autoclose'=>true,
						'format'=>'yyyy-mm-dd',
					]
			])->label('date'); ?>
			<?php 
			echo $form->field($model, 'contest_id')->dropDownList(
				\yii\helpers\ArrayHelper::map(\app\models\Contest::findEvery()->all(), 'id', 'name'),
				[
					'id' => 'contest_id',
					'prompt' => 'Select Contest',
					'disabled' => (isset($relAttributes) && isset($relAttributes['club_id'])),
				]
			);

			echo $form->field($model, 'pilot_id')->widget(DepDrop::classname(), [
				'options'=>['id'=>'pilot_id'],
				//'data' => \yii\helpers\ArrayHelper::map(app\models\Pilot::find()->all(), 'id', 'name'),
				'pluginOptions'=>[
					'depends'=>['contest_id'],
					'placeholder'=> 'Select Pilot ...',
					'url'=>Url::to(['/upload/pilot-list'])
				]
			]);

			?>
			<?= $form->field($model, 'file')->fileInput()->label('IGC File') ?>
			
			<?= $form->field($model, 'rego')->hiddenInput(['id'=>'rego'])->label(false)?>
			
		</div>

	</div>

	<!-- Prevent implicit submission of the form -->
	<button type="submit" disabled style="display: none" aria-hidden="true"></button>

	<?= Html::submitButton(
		'<span class="glyphicon glyphicon-check"></span> Upload File',
		[
			'id' => 'save-' . $model->formName(),
			'class' => 'btn btn-success'
		]
	);
	?>

	<?php   
	ActiveForm::end();

	\yii\widgets\Pjax::end(); 

	?>

</div>

<?php JSRegister::begin(); ?>
<script>

	$("#pilot_id").on('change', function(){
		var rego  = $(this).children("option:selected").text();
		$('#rego').val(rego);
	});

</script>
<?php JSRegister::end(); ?>
