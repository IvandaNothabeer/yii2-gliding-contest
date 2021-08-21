<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Transaction $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Transaction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud transaction-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Transaction') ?>
        <small>
            <?= Html::encode($model->id) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
    '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
    [ 'update', 'id' => $model->id],
    ['class' => 'btn btn-info']
) ?>

            <?= Html::a(
                '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
                ['create', 'id' => $model->id, 'Transaction'=>$copyParams],
                ['class' => 'btn btn-success']
            ) ?>

            <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . 'New',
                ['create'],
                ['class' => 'btn btn-success']
            ) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr/>

    <?php $this->beginBlock('\app\models\Transaction'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
[
    'format' => 'html',
    'attribute' => 'person_id',
    'value' => ($model->person ?
        Html::a('<i class="glyphicon glyphicon-list"></i>', ['person/index']).' '.
        Html::a('<i class="glyphicon glyphicon-circle-arrow-right"></i> '.$model->person->name, ['person/view', 'id' => $model->person->id,]).' '.
        Html::a('<i class="glyphicon glyphicon-paperclip"></i>', ['create', 'Transaction'=>['person_id' => $model->person_id]])
        :
        '<span class="label label-warning">?</span>'),
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
[
    'format' => 'html',
    'attribute' => 'type_id',
    'value' => ($model->type ?
        Html::a('<i class="glyphicon glyphicon-list"></i>', ['transaction-type/index']).' '.
        Html::a('<i class="glyphicon glyphicon-circle-arrow-right"></i> '.$model->type->name, ['transaction-type/view', 'id' => $model->type->id,]).' '.
        Html::a('<i class="glyphicon glyphicon-paperclip"></i>', ['create', 'Transaction'=>['type_id' => $model->type_id]])
        :
        '<span class="label label-warning">?</span>'),
],
        'date',
        'details',
        'quantity',
        'item_price',
        'amount',
            ],
    ]); ?>

    
    <hr/>

    <?= Html::a(
        '<span class="glyphicon glyphicon-trash"></span> ' . 'Delete',
        ['delete', 'id' => $model->id],
        [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . 'Are you sure to delete this item?' . '',
    'data-method' => 'post',
    ]
    ); ?>
    <?php $this->endBlock(); ?>


    
<?php $this->beginBlock('Launches'); ?>
<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
  <?= Html::a(
        '<span class="glyphicon glyphicon-list"></span> ' . 'List All' . ' Launches',
        ['launch/index'],
        ['class'=>'btn text-muted btn-xs']
    ) ?>
  <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New' . ' Launch',
            ['launch/create', 'Launch' => ['transaction_id' => $model->id]],
            ['class'=>'btn btn-success btn-xs']
        ); ?>
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-Launches', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-Launches ul.pagination a, th a']) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}<div class="text-center">{pager}</div>{items}<div class="text-center">{pager}</div>',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getLaunches(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-launches',
        ]
    ]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::class,
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
    'columns' => [
         'id',
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::class,
    'attribute' => 'towplane_id',
    'value' => function ($model) {
        if ($rel = $model->towplane) {
            return Html::a($rel->name, ['towplane/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::class,
    'attribute' => 'person_id',
    'value' => function ($model) {
        if ($rel = $model->person) {
            return Html::a($rel->name, ['person/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
        'date',
[
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{view} {update}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'launch' . '/' . $action;
        $params['Launch'] = ['transaction_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'launch'
],
]
])
 . '</div>'
?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


<?php $this->beginBlock('Retrieves'); ?>
<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
  <?= Html::a(
    '<span class="glyphicon glyphicon-list"></span> ' . 'List All' . ' Retrieves',
    ['retrieve/index'],
    ['class'=>'btn text-muted btn-xs']
) ?>
  <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New' . ' Retrieve',
            ['retrieve/create', 'Retrieve' => ['transaction_id' => $model->id]],
            ['class'=>'btn btn-success btn-xs']
        ); ?>
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-Retrieves', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-Retrieves ul.pagination a, th a']) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}<div class="text-center">{pager}</div>{items}<div class="text-center">{pager}</div>',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getRetrieves(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-retrieves',
        ]
    ]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::class,
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
    'columns' => [
         'id',
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::class,
    'attribute' => 'towplane_id',
    'value' => function ($model) {
        if ($rel = $model->towplane) {
            return Html::a($rel->name, ['towplane/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::class,
    'attribute' => 'person_id',
    'value' => function ($model) {
        if ($rel = $model->person) {
            return Html::a($rel->name, ['person/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
        'date',
        'duration',
        'price',
[
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{view} {update}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'retrieve' . '/' . $action;
        $params['Retrieve'] = ['transaction_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'retrieve'
],
]
])
 . '</div>'
?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


    <?= Tabs::widget(
    [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.Html::encode($model->id).'</b>',
    'content' => $this->blocks['\app\models\Transaction'],
    'active'  => true,
],
[
    'content' => $this->blocks['Launches'],
    'label'   => '<small>Launches <span class="badge badge-default">'. $model->getLaunches()->count() . '</span></small>',
    'active'  => false,
],
[
    'content' => $this->blocks['Retrieves'],
    'label'   => '<small>Retrieves <span class="badge badge-default">'. $model->getRetrieves()->count() . '</span></small>',
    'active'  => false,
],
 ]
                 ]
);
    ?>
</div>
