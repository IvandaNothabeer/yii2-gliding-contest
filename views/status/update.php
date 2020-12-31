<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Status $model
*/

$this->title = Yii::t('models', 'Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud status-update">

    <h1>
        <?= Yii::t('models', 'Status') ?>
        <small>
                        <?= Html::encode($model->id) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
