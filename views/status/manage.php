<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use app\models\Status;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\StatusSearch $searchModel
*/

$this->title = Yii::t('models', 'Manage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('app_status_view', ['route' => true])) {
	$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('app_status_update', ['route' => true])) {
	$actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('app_status_delete', ['route' => true])) {
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
<div class="giiant-crud status-index">

	<?php
	//             echo $this->render('_search', ['model' =>$searchModel]);
	?>


	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	<h1>
		<?= Yii::t('models', 'Glider Status Recording') ?>
	</h1>
	<div class="clearfix crud-navigation">
		<div class="pull-left">
			<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Tracking Updates', ['/track'], ['class' => 'btn btn-success']) ?>
		</div>
		<?php
		if(\Yii::$app->user->can('app_status_create', ['route' => true])){
		?>
			<div class="pull-right">
				<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Reset All to Grid', ['reset-grid'], ['class' => 'btn btn-warning', 'onclick'=> 'return confirm (This Will Reset All the Gliders back to Gridded)']) ?>
			</div>
		<?php
		}
		?>
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
					'attribute' => 'pilot_id',
					'value' => 'pilot.rego_short',
					'header' => 'Glider',
					'filter' => ArrayHelper::map(app\models\Pilot::find()->orderBy('rego_short ASC')->all(), 'id', 'rego_short'),
					'width' => '7%',
				],

				[
					'class' => 'kartik\grid\ActionColumn',
					'dropdown' => false,
					'vAlign'=>'middle',
					'template' => '{launch} {opsnormal} {landout} {finished} {notflying}',
					'urlCreator' => function($action, $model, $key, $index) { 
						return Url::to([$action,'id'=>$key]);
					},
					'width' => '35%',
					'buttons'=>[

						'launch' => function ($url, $model, $key) {
							return Html::submitButton('Launch', 
								[
									'data'=>['params'=>['id'=>$model->id, 'status'=>Status::STATUS_LAUNCHED]],                               
									'data-method' => 'post',
									'class' => 'btn btn-sm btn-primary',
							]);
						},
						'opsnormal' => function ($url, $model, $key ) {
							return Html::submitButton('Ops Normal',
								[
									'data'=>['params'=>['id'=>$model->id, 'status'=>Status::STATUS_OPS_NORMAL_RADIO]],                               
									'data-method' => 'post',
									'class' => 'btn btn-sm btn-success',
							]);
						},
						'landout' => function ($url, $model, $key) {
							return Html::submitButton('Landout',
								[
									'data'=>['params'=>['id'=>$model->id, 'status'=>Status::STATUS_LANDED_OUT]],                               
									'data-method' => 'post',
									'class' => 'btn btn-sm btn-warning',
							]);
						},
						'finished' => function ($url, $model, $key) {
							return Html::submitButton('Finished',
								[
									'data'=>['params'=>['id'=>$model->id, 'status'=>Status::STATUS_FINISHED]],                               
									'data-method' => 'post',
									'class' => 'btn btn-sm btn-success',
							]);
						},
						'notflying' => function ($url, $model, $key) {
							return Html::submitButton('Not Flying',
								[
									'data'=>['params'=>['id'=>$model->id, 'status'=>Status::STATUS_NOT_FLYING]],                               
									'data-method' => 'post',
									'class' => 'btn btn-sm btn-danger',
							]);
						},
					],

				],
				[
					'class' => 'kartik\grid\EditableColumn',
					'attribute'=>'status',
					'filter' => app\models\Status::optsStatus(),

					'editableOptions'=> [
						'format' => Editable::FORMAT_BUTTON,
						'inputType' => Editable::INPUT_DROPDOWN_LIST,
						'asPopover' =>false,
						'data' => app\models\Status::optsStatus(),
						'formOptions' => ['action' => ['/status/editstatus']],
					]    
				],
				[
					'class' => 'kartik\grid\EditableColumn',
					'attribute'=>'date',
					'editableOptions'=> [
						'format' => Editable::FORMAT_BUTTON,
						'inputType' => Editable::INPUT_DATE,
						'asPopover' =>false,
						'formOptions' => ['action' => ['/status/editstatus']],
						'options' => ['pluginOptions'=>['autoclose' => true, 'format' => 'yyyy-mm-dd']],
					]    
				],
				[
					'class' => 'kartik\grid\EditableColumn',
					'attribute'=>'time',
					'editableOptions'=> [
						'format' => Editable::FORMAT_BUTTON,
						'inputType' => Editable::INPUT_TIME,
						'asPopover' =>false,
						'formOptions' => ['action' => ['/status/editstatus']],
						'options' => ['pluginOptions'=>['autoclose' => true, 'showSeconds'=>false, 'showMeridian'=>false]],
					]    
				],
			]
		]); ?>
	</div>

</div>


<?php \yii\widgets\Pjax::end() ?>


