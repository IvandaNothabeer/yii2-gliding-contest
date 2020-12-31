<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Retrieve $model
*/

$this->title = Yii::t('models', 'Retrieve');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Retrieves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud retrieve-create">

    <h1>
        <?= Yii::t('models', 'Retrieve') ?>
        <small>
                        <?= Html::encode($model->id) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
