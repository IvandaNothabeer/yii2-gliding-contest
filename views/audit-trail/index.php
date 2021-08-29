<?php

use app\models\Pilot;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\AuditTrail $searchModel
 */

$this->title = 'Status Update';
$this->params['breadcrumbs'][] = $this->title;


/**
 * create action column template depending acces rights
 */
$actionColumnTemplates = [];

if (\Yii::$app->user->can('app_audit-trail_view', ['route' => true])) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('app_audit-trail_update', ['route' => true])) {
    $actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('app_audit-trail_delete', ['route' => true])) {
    $actionColumnTemplates[] = '{delete}';
}
if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">' . $actionColumnTemplateString . '</div>';
?>
<div class="giiant-crud audit-trail-index">

    <?php
    //             echo $this->render('_search', ['model' =>$searchModel]);
    ?>


    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-main', 'enableReplaceState' => false, 'linkSelector' => '#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', 'Status Update') ?>
        <small>
            History
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <?php
        if (\Yii::$app->user->can('app_audit-trail_create', ['route' => true])) {
        ?>
            <div class="pull-left">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        <?php
        }
        ?>
        <div class="pull-right">


            <?=
            \yii\bootstrap\ButtonDropdown::widget(
                [
                    'id' => 'giiant-relations',
                    'encodeLabel' => false,
                    'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Relations',
                    'dropdown' => [
                        'options' => [
                            'class' => 'dropdown-menu-right'
                        ],
                        'encodeLabels' => false,
                        'items' => []
                    ],
                    'options' => [
                        'class' => 'btn-default'
                    ]
                ]
            );
            ?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::class,
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
            ],
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns' => [
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => $actionColumnTemplateString,
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('cruds', 'View'),
                                'aria-label' => Yii::t('cruds', 'View'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        // using the column name as key, not mapping to 'id' like the standard generator
                        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                        $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                        return Url::toRoute($params);
                    },
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
                'stamp',
                'action',
                //'model',
                [
                    'attribute' => 'model',
                    'value' => function ($model, $index, $widget) {
                        $p = explode('\\', $model->model);
                        return end($p);
                    }
                ],
                //'model_id',
                [
                    'attribute' => 'model_id',
                    'label' => 'Glider',
                    'filter' => yii\helpers\ArrayHelper::map(app\models\Pilot::find()->all(), 'id', 'rego'),
                    'value' => function ($model, $index, $widget) {
                        return app\models\Pilot::findOne($model->model_id)->rego;
                    }
                ],
                'field',
                //'user_id',
                [
                    'attribute' => 'user_id',
                    'label' => 'Updated By',
                    'filter' => yii\helpers\ArrayHelper::map(app\models\User::find()->all(), 'id', 'username'),
                    'value' => function ($model, $index, $widget) {
                        return app\models\User::findOne($model->user_id)->getAttribute('username');
                    }
                ],
                'old_value:ntext',
                'new_value:ntext',
            ]
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>