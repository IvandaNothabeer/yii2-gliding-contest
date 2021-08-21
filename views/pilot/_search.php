<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\Pilot $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="pilot-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'person_id') ?>

		<?= $form->field($model, 'contest_id') ?>

		<?= $form->field($model, 'gnz_id') ?>

		<?= $form->field($model, 'rego') ?>

		<?php // echo $form->field($model, 'rego_short') ?>

		<?php // echo $form->field($model, 'entry_date') ?>

		<?php // echo $form->field($model, 'trailer') ?>

		<?php // echo $form->field($model, 'plate') ?>

		<?php // echo $form->field($model, 'crew') ?>

		<?php // echo $form->field($model, 'crew_phone') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
