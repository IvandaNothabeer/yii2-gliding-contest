<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\DefaultType $model
*/

$this->title = Yii::t('models', 'Default Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Default Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud default-type-create">

    <h1>
        <?= Yii::t('models', 'Default Type') ?>
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
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
