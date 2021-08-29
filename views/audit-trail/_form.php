<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var sammaye\audittrail\AuditTrail $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="audit-trail-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AuditTrail',
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
            

<!-- attribute action -->
			<?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

<!-- attribute model -->
			<?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

<!-- attribute stamp -->
			<?= $form->field($model, 'stamp')->textInput() ?>

<!-- attribute model_id -->
			<?= $form->field($model, 'model_id')->textInput(['maxlength' => true]) ?>

<!-- attribute field -->
			<?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

<!-- attribute old_value -->
			<?= $form->field($model, 'old_value')->textarea(['rows' => 6]) ?>

<!-- attribute new_value -->
			<?= $form->field($model, 'new_value')->textarea(['rows' => 6]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'AuditTrail'),
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

