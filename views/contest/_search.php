<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\Contest $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="contest-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'club_id') ?>

		<?= $form->field($model, 'gnz_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'start') ?>

		<?php // echo $form->field($model, 'end')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
