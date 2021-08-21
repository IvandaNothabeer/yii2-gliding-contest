<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Pilot $model
*/

$this->title = Yii::t('models', 'Pilot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Pilots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud pilot-create">

    <h1>
        <?= Yii::t('models', 'Pilot') ?>
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
