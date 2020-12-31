<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\LandoutSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="landout-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'pilot_id') ?>

		<?= $form->field($model, 'date') ?>

		<?= $form->field($model, 'landed_at') ?>

		<?= $form->field($model, 'departed_at') ?>

		<?php // echo $form->field($model, 'returned_at') ?>

		<?php // echo $form->field($model, 'lat') ?>

		<?php // echo $form->field($model, 'lng') ?>

		<?php // echo $form->field($model, 'address') ?>

		<?php // echo $form->field($model, 'trailer') ?>

		<?php // echo $form->field($model, 'plate') ?>

		<?php // echo $form->field($model, 'crew') ?>

		<?php // echo $form->field($model, 'crew_phone') ?>

		<?php // echo $form->field($model, 'notes') ?>

		<?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
