<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Contest $model
*/

$this->title = Yii::t('models', 'Contest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud contest-create">

    <h1>
        <?= Yii::t('models', 'Contest') ?>
        <small>
                        <?= Html::encode($model->name) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
    'Cancel',
    \yii\helpers\Url::previous(),
    ['class' => 'btn btn-default']
) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
