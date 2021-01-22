<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

	<?php $form = ActiveForm::begin(); ?>


	<?php

	echo $form->field($model, 'club_id')->dropDownList(
		\yii\helpers\ArrayHelper::map(app\models\Club::find()->all(), 'id', 'name'),
		[
			'id' => 'club_id',
			'prompt' => 'Select',
			'disabled' => (isset($relAttributes) && isset($relAttributes['club_id'])),
		]
	);

	echo $form->field($model, 'contest_id')->widget(DepDrop::classname(), [
		'options'=>['id'=>'contest_id'],
		'data' => \yii\helpers\ArrayHelper::map(app\models\Contest::find()->all(), 'id', 'name'),
		'pluginOptions'=>[
			'depends'=>['club_id'],
			'placeholder'=> 'Select Contest ...',
			'url'=>Url::to(['/contest/byclub'])
		]
	]);

	?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>


	<?= yii\helpers\Html::label('Display Theme') ?>
	<?= app\widgets\ThemePicker::widget(); ?>


</div>