<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\Pilot $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="pilot-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Pilot',
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
            

<!-- attribute person_id -->
			<?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
$form->field($model, 'person_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(app\models\Person::find()->all(), 'id', 'name'),
    [
        'prompt' => 'Select',
        'disabled' => (isset($relAttributes) && isset($relAttributes['person_id'])),
    ]
); ?>

<!-- attribute contest_id -->
			<?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
$form->field($model, 'contest_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(app\models\Contest::find()->all(), 'id', 'name'),
    [
        'prompt' => 'Select',
        'disabled' => (isset($relAttributes) && isset($relAttributes['contest_id'])),
    ]
); ?>

<!-- attribute gnz_id -->
			<?= $form->field($model, 'gnz_id')->textInput() ?>

<!-- attribute entry_date -->
			<?= $form->field($model, 'entry_date')->textInput() ?>

<!-- attribute rego -->
			<?= $form->field($model, 'rego')->textInput(['maxlength' => true]) ?>

<!-- attribute rego_short -->
			<?= $form->field($model, 'rego_short')->textInput(['maxlength' => true]) ?>

<!-- attribute trailer -->
			<?= $form->field($model, 'trailer')->textInput(['maxlength' => true]) ?>

<!-- attribute crew -->
			<?= $form->field($model, 'crew')->textInput(['maxlength' => true]) ?>

<!-- attribute plate -->
			<?= $form->field($model, 'plate')->textInput(['maxlength' => true]) ?>

<!-- attribute crew_phone -->
			<?= $form->field($model, 'crew_phone')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Pilot'),
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

