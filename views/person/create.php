<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Person $model
*/

$this->title = Yii::t('models', 'Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud person-create">

    <h1>
        <?= Yii::t('models', 'Person') ?>
        <small>
                        <?= Html::encode($model->name) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> ' . 'Return To Setup', ['site/setup'], ['class' => 'btn btn-success']) ?>
        </div>
        
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
