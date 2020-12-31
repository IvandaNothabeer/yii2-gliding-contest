<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\Transaction $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'pilot_id') ?>

		<?= $form->field($model, 'type_id') ?>

		<?= $form->field($model, 'details') ?>

		<?= $form->field($model, 'amount') ?>

		<?php // echo $form->field($model, 'date')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
