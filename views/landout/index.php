<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\Pilot;
use app\models\Landout;
use richardfan\widget\JSRegister;


/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\LandoutSearch $searchModel
*/


// Register Leaflet Components
$this->registerCssFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.css',
	[
		'integrity' => 'sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==',
		'crossorigin' => '',
]);
$this->registerJsFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.js',
	[
		'integrity' => 'sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==',
		'crossorigin' => '',
]);


$this->title = Yii::t('models', 'Landouts');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('app_landout_view', ['route' => true])) {
	$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('app_landout_update', ['route' => true])) {
	$actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('app_landout_delete', ['route' => true])) {
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
<div class="giiant-crud landout-index">

	<?php
	//             echo $this->render('_search', ['model' =>$searchModel]);
	?>


	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	<h1>
		<?= Yii::t('models', 'Landouts') ?>
		<small>
			List
		</small>
	</h1>
	<div class="clearfix crud-navigation">
		<?php
		if(\Yii::$app->user->can('app_landout_create', ['route' => true])){
		?>
			<div class="pull-left">
				<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New Landout', ['create'], ['class' => 'btn btn-success']) ?>
			</div>
		<?php
		}
		?>

		<?php
		if(\Yii::$app->user->can('app_landout_create', ['route' => true])){
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
								[
									'url' => ['pilot/index'],
									'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Pilot'),
								],

							]
						],
						'options' => [
							'class' => 'btn-default'
						]
					]
				);
				?>
			</div>
		<?php
		}
		?>
	</div>

	<hr />

	<div class=row>
		<div class=col-md-6>
			<div class="table-responsive">
				<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'pager' => [
						'class' => yii\widgets\LinkPager::className(),
						'firstPageLabel' => 'First',
						'lastPageLabel' => 'Last',
					],
					'filterModel' => $searchModel,
					'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
					'headerRowOptions' => ['class'=>'x'],
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
							'urlCreator' => function($action, $model, $key, $index) {
								// using the column name as key, not mapping to 'id' like the standard generator
								$params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
								$params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
								return Url::toRoute($params);
							},
							'contentOptions' => ['nowrap'=>'nowrap']
						],
						[
							'attribute'=>'date',
							'value' =>'date',
							'filter'=>DatePicker::widget([
								'model' => $searchModel,
								'attribute'=>'date',
								'pluginOptions' => [
									'autoclose' => true,
									'todayHighlight' => true,
									'todayBtn' => true,
									'format' => 'yyyy-mm-dd'
								]
							])       
						],
						[
							'class' => yii\grid\DataColumn::className(),
							'attribute' => 'pilot_id',
							'value' => function ($model) {
								if ($rel = $model->pilot) {
									return Html::a($rel->rego_short, ['pilot/view', 'id' => $rel->id,], ['data-pjax' => 0]);
								} else {
									return '';
								}
							},
							'format' => 'raw',
							'label' => 'Glider',
							'filter' => (ArrayHelper::map(Pilot::find()->orderBy('rego_short ASC')->all(),'id','rego_short')),
						],
						// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
						[
							'class' => yii\grid\DataColumn::className(),
							'attribute' => 'pilot_id',
							'value' => function ($model) {
								if ($rel = $model->pilot) {
									return Html::a($rel->name, ['pilot/view', 'id' => $rel->id,], ['data-pjax' => 0]);
								} else {
									return '';
								}
							},
							'format' => 'raw',
							'filter' => (ArrayHelper::map(Pilot::find()->all(),'id','name')),
						],
						'landed_at',
						//'departed_at',
						//'returned_at',
						//'lat',
						//'lng',
						//'address:ntext',
						/*'notes:ntext',*/
						[
							'attribute'=>'status',
							'value' => function ($model) {
								return Landout::getStatusValueLabel($model->status);
							}, 
							'filter' => (Landout::optsStatus()),   
						],
						/*'trailer',*/
						/*'crew',*/
						/*'plate',*/
						/*'crew_phone',*/
					]
				]); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div id="map" style="height: 600px;"></div>
		</div>
	</div>

</div>




<?php JSRegister::begin(); ?>

<script>


	// Set up the Map. Begin Drawing at 0,0. 
	// 'map' and 'marker' are global objects that can be updated later
	var map = L.map('map').setView({lon: 176, lat: -38}, 8);

	// show the scale bar on the lower left corner
	L.control.scale().addTo(map);

	var cartoAttribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>';
	var mapLayers = {

		streetmap: 	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
		}),
		terrain: L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}.png', {
			attribution: 'Map tiles by <a href="https://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://www.openstreetmap.org/copyright">ODbL</a>.',
		}),
		opentopomap: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
			maxZoom: 17,
			attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
		}),		
		satellite: L.tileLayer('https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
			attribution: 'Powered by Esri Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
		})
	};

	var layersControl = L.control.layers({
		'Street Map': mapLayers.streetmap,
		'Terrain': mapLayers.terrain,
		'Topology': mapLayers.opentopomap,
		'Satellite': mapLayers.satellite
	});

	mapLayers.terrain.addTo(map);
	layersControl.addTo(map);

	//var trackLatLong = [];
	//var timePositionMarker;
	//L.AwesomeMarkers.Icon.prototype.options.prefix = 'fa';
	//var planeIcon = L.AwesomeMarkers.icon({
	//	icon: 'plane',
	//	iconColor: 'white',
	//	markerColor: 'red'
	//});


	// Get landouts for Selected Day

	$(document).ready(function()
		{
			var date = $("[name='LandoutSearch[date]']").val();
			var max_lat = -90;
			var min_lat = 90;
			var max_lon = -180;
			var min_lon = 180;
			$.get('landout/get-all?date=' + date, function(data, status){
				$.each(data, function (index, value){
					// show a marker on the map
					var marker = L.marker({lon: value.lon , lat: value.lat}).bindPopup(value.rego).addTo(map);
					if (value.lat > max_lat) {max_lat = value.lat};
					if (value.lat < min_lat) {min_lat = value.lat};
					if (value.lon > max_lon) {max_lon = value.lon};
					if (value.lon < min_lon) {min_lon = value.lon};

				});

				var center_lat = +((max_lat - min_lat) / 2) + +min_lat;
				var center_lon = +((max_lon - min_lon) / 2) + +min_lon;

				map.setView({lon: center_lon, lat: center_lat}, 8);		
			});

	});


</script>

<?php JSRegister::end(); ?>

<?php \yii\widgets\Pjax::end() ?>