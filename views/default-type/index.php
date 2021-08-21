<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\DefaultType $searchModel
*/

$this->title = Yii::t('models', 'Default Prices');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('app_default-type_view', ['route' => true])) {
	$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('app_default-type_update', ['route' => true])) {
	$actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('app_default-type_delete', ['route' => true])) {
	$actionColumnTemplates[] = '{delete}';
}
if (isset($actionColumnTemplates)) {
	$actionColumnTemplate = implode(' ', $actionColumnTemplates);
	$actionColumnTemplateString = $actionColumnTemplate;
} else {
	Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
	$actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud default-type-index">

	<?php
	//             echo $this->render('_search', ['model' =>$searchModel]);
	?>


	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	<h1>
		<?= Yii::t('models', 'Default Prices') ?>
		<small>
			For all New Contests
		</small>
	</h1>
	<div class="clearfix crud-navigation">
		<?php
		if(\Yii::$app->user->can('app_default-type_create', ['route' => true])){
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
						'items' => [

						]
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
			'headerRowOptions' => ['class'=>'x'],
			'columns' => [
				[
					'class' => yii\grid\DataColumn::class,
					'attribute' => 'name',
					'value' => function ($model) {
						return Html::a($model->name, ['view', 'id' => $model->id,], ['data-pjax' => 0]);
					},
					'format' => 'raw',
				],
				'description',
				[
					'attribute'=>'credit',
					'value' => function ($model) {
						return \app\models\DefaultType::getCreditValueLabel($model->credit);
					}    
				],
				'price',
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
					'urlCreator' => function($action, $model, $key, $index) {
						// using the column name as key, not mapping to 'id' like the standard generator
						$params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
						$params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
						return Url::toRoute($params);
					},
					'contentOptions' => ['nowrap'=>'nowrap']
				]
			]
		]); ?>
	</div>

</div>


<?php \yii\widgets\Pjax::end() ?>


