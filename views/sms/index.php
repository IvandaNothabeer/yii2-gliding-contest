<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SmsForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Send SMS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>


        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'sms-form']); ?>

                    <?= $form->field($model, 'to')->dropDownList(
                        array_merge([0=>'Everyone'],
                        \Yii\helpers\ArrayHelper::map(app\models\Person::find()->all(),'id', 'name')), 
                        ['autofocus' => true]) ?>

                    <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

</div>


