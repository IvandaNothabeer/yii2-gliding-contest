<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Towplane $model
*/

$this->title = Yii::t('models', 'Contest Towplane');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Contest Towplanes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud towplane-create">

    <h1>
        <?= Yii::t('models', 'Add Towplane to Contest') ?>
        <small>
                <?= Html::encode($model->rego) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">

            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Create a Towplane', ['master-towplane/create'], ['class' => 'btn btn-success']) ?>

            <?=             Html::a(
    'Cancel',
    \yii\helpers\Url::previous(),
    ['class' => 'btn btn-default']
) ?>
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
