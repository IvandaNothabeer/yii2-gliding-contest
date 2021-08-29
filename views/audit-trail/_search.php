<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\AuditTrail $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="audit-trail-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'old_value') ?>

		<?= $form->field($model, 'new_value') ?>

		<?= $form->field($model, 'action') ?>

		<?= $form->field($model, 'model') ?>

		<?php // echo $form->field($model, 'field') ?>

		<?php // echo $form->field($model, 'stamp') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'model_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
