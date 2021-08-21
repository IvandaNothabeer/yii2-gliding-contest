<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\Person $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="person-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'contest_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'address1') ?>

		<?= $form->field($model, 'address2') ?>

		<?php // echo $form->field($model, 'address3') ?>

		<?php // echo $form->field($model, 'postcode') ?>

		<?php // echo $form->field($model, 'role') ?>

		<?php // echo $form->field($model, 'telephone') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
