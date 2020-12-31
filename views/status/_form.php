<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use app\models\Pilot;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

/**
* @var yii\web\View $this
* @var app\models\Status $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="status-form">

	<?php $form = ActiveForm::begin([
		'id' => 'Status',
		'layout' => 'horizontal',
		'enableClientValidation' => true,
		'errorSummaryCssClass' => 'error-summary alert alert-danger',
		'fieldConfig' => [
			'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			'horizontalCssClasses' => [
				'label' => 'col-sm-2',
				#'offset' => 'col-sm-offset-4',
				'wrapper' => 'col-sm-8',
				'error' => '',
				'hint' => '',
			],
		],
		]
	);
	?>

	<div class="">
		<?php $this->beginBlock('main'); ?>

		<p>


			<!-- attribute pilot_id -->
			<?= 
			$form->field($model, 'pilot_id')->dropDownList(
				ArrayHelper::map(Pilot::find()->orderBy('rego_short ASC')->all(),'id', 'rego_short')
			)->label('Glider');
			?>

			<!-- attribute status -->
			<?=                         $form->field($model, 'status')->dropDownList(
				app\models\Status::optsstatus()
			); ?>

			<!-- attribute date -->
				<?php
				echo $form->field($model, 'date')->widget(DatePicker::classname(), [
					'type' => DatePicker::TYPE_COMPONENT_PREPEND,
					'pluginOptions' => [
						'autoclose' => true,
						'todayHighlight' => true,
						'todayBtn' => true,
						'format' => 'yyyy-mm-dd'
					]
				]);
				?>

			<!-- attribute time -->
						<?php
						echo $form->field($model, 'time')->widget(TimePicker::classname(), [
							'pluginOptions' => [
								'autoclose' => true,
								'defaultTime' => false,
								'showMeridian' => false,
								'showSeconds' => false,
							]
						]);
						?>	
		</p>
		<?php $this->endBlock(); ?>

		<?=
		Tabs::widget(
			[
				'encodeLabels' => false,
				'items' => [ 
					[
						'label'   => Yii::t('models', 'Status'),
						'content' => $this->blocks['main'],
						'active'  => true,
					],
				]
			]
		);
		?>
		<hr/>

		<?php echo $form->errorSummary($model); ?>

		<?= Html::submitButton(
			'<span class="glyphicon glyphicon-check"></span> ' .
			($model->isNewRecord ? 'Create' : 'Save'),
			[
				'id' => 'save-' . $model->formName(),
				'class' => 'btn btn-success'
			]
		);
		?>

		<?php ActiveForm::end(); ?>

	</div>

</div>

