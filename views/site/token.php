<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Access Token';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-token">
    <h1><?= Html::encode($this->title) ?></h1>


        <div class="row">
            <div class="col-lg-5">
                <h5>An Access Token is required to link the Contest Manager to the GNZ Entry Forms. This needs to be refreshed each season. Only update this token if you know what you are doing </h5>
                <br>
                <h5> Generate a Personal Access Token here - <?= Html::a('GNZ Oauth Page', 'https://gliding.net.nz/oauth',['target'=>'_blank']) ?></h5>
                <br>
                <?php $form = ActiveForm::begin(['id' => 'token-form']); ?>

                    <?= $form->field($model, 'token')->textInput(['autofocus' => true]) ?>


                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

</div>