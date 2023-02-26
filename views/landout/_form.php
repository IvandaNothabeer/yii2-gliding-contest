<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\widgets\MaskedInput;
use kartik\number\NumberControl;
use richardfan\widget\JSRegister;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\Landout $model
* @var yii\widgets\ActiveForm $form
*/

?>

<?php
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


// Register Leaflet Full Screen Add In
$this->registerCssFile('https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css');
$this->registerJsFile('https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js');


// Register Leaflet Screen Shot Add In
$this->registerJsFile('https://unpkg.com/leaflet-simple-map-screenshoter');

?>

<div class="landout-form">

	<?php $form = ActiveForm::begin([
		'id' => 'Landout',
		//'layout' => 'horizontal',
		'enableClientValidation' => true,
		'errorSummaryCssClass' => 'error-summary alert alert-danger',
		'fieldConfig' => [
			'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			'horizontalCssClasses' => [
				'label' => 'col-sm-2',
				#'offset' => 'col-sm-offset-4',
				'wrapper' => 'col-sm-8',
				'error' => '',
				'hint' => '',
			],
		],
		]
	);
	?>

	<div class="clearfix crud-navigation">
		<div class="pull-right">
			<?=             Html::a(
				'Cancel',
				\yii\helpers\Url::previous(),
				['class' => 'btn btn-default']) ?>
		</div>

		<div class="pull-left">
			<?= Html::submitButton(
				'<span class="glyphicon glyphicon-check"></span> ' .
				($model->isNewRecord ? 'Save New Landout' : 'Save Changes'),
				[
					'id' => 'save-' . $model->formName(),
					'class' => 'btn btn-success'
				]
			);
			?>
		</div>
		<label class='pull-left control-label' style="padding-top: 5px; padding-left: 25px; padding-right: 10px;text-align: right;">
			Fetch Details for Glider	
		</label>
		<div class="pull-left">
			<?=	$form->field($model, 'pilot_id')->dropDownList(
					\yii\helpers\ArrayHelper::map(app\models\Pilot::find()->orderBy('rego_short ASC')->all(), 'id', 'rego_short'),
					[
						'prompt' => 'Select',
						'disabled' => (isset($relAttributes) && isset($relAttributes['pilot_id'])),
					]
				)->hint(false)->label(false); 
			?>
		</div>
	</div>

	<div class="">

		<div class="row">
			<div class="col-md-1">
				<?= $form->field($model,'rego_short')->hint(false)->label('Glider Reg') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model,'name')->hint(false) ?>
			</div>
			<div class="col-md-2">
				<?= $form->field($model,'telephone')->hint(false) ?>
			</div>
			<div class="col-md-2" style="z-index:999">
				<?php
				echo $form->field($model, 'date')->widget(DatePicker::class, [
					'type' => DatePicker::TYPE_COMPONENT_PREPEND,
					'pluginOptions' => [
						'autoclose' => true,
						'todayHighlight' => true,
						'todayBtn' => true,
						'format' => 'yyyy-mm-dd'
					]
				])->hint(false);
				?>
			</div>
			<div class="col-md-2">
				<?php
				echo $form->field($model, 'landed_at')->widget(TimePicker::class, [
					'pluginOptions' => [
						'autoclose' => true,
						'defaultTime' => 'current',
						'showMeridian' => false,
						'showSeconds' => false,
					]
				])->hint(false);
				?>
			</div>
			<div class="col-md-2">
				<!-- attribute status -->
				<?='<label class="control-label">Status</label>' ?>
				<?= $form->field($model, 'status')->dropDownList(
					app\models\Landout::optsstatus()
				)->label(false)->hint(false); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<!-- attribute lat -->
				<?='<label class="control-label">D:M:S Lat</label>' ?>
				<?=Html::textInput('dmslat',0,['id'=>'dmslat', 'class'=>'form-control']) ?>
			</div>
			<div class="col-md-2">
				<!-- attribute lon -->
				<?='<label class="control-label">D:M:S Lon</label>' ?>
				<?=Html::textInput('dmslon',0,['id'=>'dmslon', 'class'=>'form-control']) ?>
			</div>
			<div class="col-md-2">
				<!-- attribute lat -->
				<?='<label class="control-label">D:M.D Lat</label>' ?>
				<?=Html::textInput('dmdlat',0,['id'=>'dmdlat', 'class'=>'form-control']) ?>
			</div>
			<div class="col-md-2">
				<!-- attribute lon -->
				<?='<label class="control-label">D:M.D Lon</label>' ?>
				<?=Html::textInput('dmdlon',0,['id'=>'dmdlon', 'class'=>'form-control']) ?>
			</div>
			<div class="col-md-2">
				<!-- attribute lat -->
				<?='<label class="control-label">D.DD Lat</label>' ?>
				<?=Html::textInput('dddlat',0,['id'=>'dddlat', 'class'=>'form-control']) ?>
			</div>
			<div class="col-md-2">
				<!-- attribute lon -->
				<?='<label class="control-label">D.DD Lon</label>' ?>
				<?=Html::textInput('dddlon',0,['id'=>'dddlon', 'class'=>'form-control']) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class='col-md-6'>
						<?='<label class="control-label">Turnpoint</label>' ?>
						<?= Select2::widget([
							'name' => 'nearest_waypoint',
							'id' => 'landout-nearest_waypoint',
							'data' => Yii::$app->gnz->getWaypointNames(),
							'pluginOptions' => ['highlight' => true],
							'options' => ['placeholder' => 'Waypoint ...'],
						]); ?>
					</div>
					<div class='col-md-6'>
						<?='<label class="control-label">Last tracked Position</label>'  ?> </br>
						<?= Html::button('Get Last Position', ['class'=>'btn btn-md btn-success', 'id'=>'get-last-position']) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<!-- attribute address -->
						<?= $form->field($model, 'address')->textarea(['rows' => 5])->hint(false) ?>
					</div>
					<div class="col-md-6">
						<!-- attribute notes -->
						<?= $form->field($model, 'notes')->textarea(['rows' => 5])->hint(false)  ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<!-- attribute trailer -->
						<?= $form->field($model, 'trailer')->textInput(['maxlength' => true])->hint(false)  ?>
					</div>
					<div class="col-md-4">
						<!-- attribute plate -->
						<?= $form->field($model, 'plate')->textInput(['maxlength' => true])->hint(false)  ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<!-- attribute crew -->
						<?= $form->field($model, 'crew')->textInput(['maxlength' => true])->hint(false)  ?>
					</div>
					<div class="col-md-4">
						<!-- attribute crew_phone -->
						<?= $form->field($model, 'crew_phone')->textInput(['maxlength' => true])->hint(false)  ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<?php
						echo $form->field($model, 'departed_at')->widget(TimePicker::class, [
							'pluginOptions' => [
								'autoclose' => true,
								'defaultTime' => false,
								'showMeridian' => false,
								'showSeconds' => false,
							]
						])->hint(false) ;
						?>	
					</div>
					<div class="col-md-6">
						<?php
						echo $form->field($model, 'returned_at')->widget(TimePicker::class, [
							'pluginOptions' => [
								'autoclose' => true,
								'defaultTime' => false,
								'showMeridian' => false,
								'showSeconds' => false,
							]
						])->hint(false) ;
						?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<?=Html::label('Map')?>
				<div id="map" style="height: 400px;"></div>
			</div>

		</div>

		<!-- attribute lat -->
		<?= $form->field($model, 'lat')->hiddenInput()->label(false)->hint(false) ?>

		<!-- attribute lng -->
		<?= $form->field($model, 'lng')->hiddenInput()->label(false)->hint(false) ?>

		<?php echo $form->errorSummary($model); ?>

		<!-- Prevent implicit submission of the form -->

		<?php ActiveForm::end(); ?>




	</div>

</div>

<?php JSRegister::begin(); ?>

<script>

	$('#landout-pilot_id').change(function(e) {
		$.ajax({
			url: 'pilot',
			data: {id: $('#landout-pilot_id').val()},
			success: function(data) {
				$('#landout-rego_short').val(data['rego_short']);
				$('#landout-name').val(data['name']);
				$('#landout-telephone').val(data['telephone']);
				$('#landout-crew').val(data['crew']);
				$('#landout-crew_phone').val(data['crew_phone']);
				$('#landout-trailer').val(data['trailer']);
				$('#landout-plate').val(data['plate']);
			}
		});
	});

	$('#landout-nearest_waypoint').change(function(e) {
		$.ajax({
			url: 'waypoint',
			data: {id: $('#landout-nearest_waypoint').val()},
			success: function(data) {

				$('#dmdlat').val(data['lat']);
				var ddd_lat = dmd_to_ddd(data['lat']);
				var dms_lat = dmd_to_dms(data['lat']);
				$('#landout-lat').val(ddd_lat);
				$('#dmslat').val(dms_lat);
				$('#dddlat').val(ddd_lat);

				$('#dmdlon').val(data['long']);
				var ddd_lon = dmd_to_ddd(data['long']);
				var dms_lon = dmd_to_dms(data['long']);
				$('#landout-lng').val(ddd_lon);
				$('#dmslon').val(dms_lon);
				$('#dddlon').val(ddd_lon);

				refresh_map( ddd_lat, ddd_lon )
			}
		});
	});

	$('#get-last-position').click(function(e) {
		document.body.style.cursor = 'wait';
		$.ajax({
			url: 'getposition',
			data: {id: $('#landout-pilot_id option:selected' ).text()},
			success: function(data) {

				$('#dddlat').val(data['lat']);
				var dmd_lat = ddd_to_dmd(data['lat']);
				var dms_lat = ddd_to_dms(data['lat']);
				$('#landout-lat').val(data['lat']);
				$('#dmslat').val(dms_lat);
				$('#dmdlat').val(dmd_lat);

				$('#dddlon').val(data['long']);
				var dmd_lon = ddd_to_dmd(data['long']);
				var dms_lon = ddd_to_dms(data['long']);
				$('#landout-lng').val(data['long']);
				$('#dmslon').val(dms_lon);
				$('#dmdlon').val(dmd_lon);

				refresh_map( data['lat'], data['long'] )
			}
		})
		.always(function() {
			document.body.style.cursor = 'pointer';
		});
	});

	$("#dmslat").change(function(){
		var dms = $('#dmslat').val();
		var dmd = dms_to_dmd(dms);	
		var ddd = dms_to_ddd(dms);		
		$('#landout-lat').val(ddd);
		$('#dmdlat').val(dmd);
		$('#dddlat').val(ddd);
		refresh_map(ddd,$('#dddlon').val())
	});                     

	$("#dmslon").change(function(){
		var dms = $('#dmslon').val();
		var dmd = dms_to_dmd(dms);	
		var ddd = dms_to_ddd(dms);		
		$('#landout-lng').val(ddd);
		$('#dmdlon').val(dmd);
		$('#dddlon').val(ddd);
		refresh_map($('#dddlat').val(),ddd)
	});

	$("#dmdlat").change(function(){
		var dmd = $('#dmdlat').val();
		var dms = dmd_to_dms(dmd);	
		var ddd = dmd_to_ddd(dmd);		
		$('#landout-lat').val(ddd);
		$('#dmslat').val(dms);
		$('#dddlat').val(ddd);
		refresh_map(ddd,$('#dddlon').val())
	});                     

	$("#dmdlon").change(function(){
		var dmd = $('#dmdlon').val();
		var dms = dmd_to_dms(dmd);	
		var ddd = dmd_to_ddd(dmd);		
		$('#landout-lng').val(ddd);
		$('#dmslon').val(dms);
		$('#dddlon').val(ddd);
		refresh_map($('#dddlat').val(),ddd)
	});

	$("#dddlat").change(function(){
		var ddd = $('#dddlat').val();
		var dms = ddd_to_dms(ddd);	
		var dmd = ddd_to_dmd(ddd);		
		$('#landout-lat').val(ddd);
		$('#dmslat').val(dms);
		$('#dmdlat').val(dmd);
		refresh_map(ddd,$('#dddlon').val())
	});                     

	$("#dddlon").change(function(){
		var ddd = $('#dddlon').val();
		var dms = ddd_to_dms(ddd);	
		var dmd = ddd_to_dmd(ddd);		
		$('#landout-lng').val(ddd);
		$('#dmslon').val(dms);
		$('#dmdlon').val(dmd);
		refresh_map($('#dddlat').val(),ddd)
	});


	$("#landout-lat").ready(function() {
		var ddd = $("#landout-lat").val();
		var dms = ddd_to_dms(ddd);	
		var dmd = ddd_to_dmd(ddd);		
		$('#dmslat').val(dms);
		$('#dmdlat').val(dmd);
		$('#dddlat').val(ddd);
		refresh_map(ddd,$('#dddlon').val())
	});

	$("#landout-lng").ready(function() {
		var ddd = $("#landout-lng").val();
		var dms = ddd_to_dms(ddd);	
		var dmd = ddd_to_dmd(ddd);
		$('#dmslon').val(dms);
		$('#dmdlon').val(dmd);
		$('#dddlon').val(ddd);
		refresh_map($('#dddlat').val(),ddd)
	});


	function dms_to_ddd (dms){
		var coord = dms.split(":");
		var absolute = Math.abs(coord[0]);
		var sign = coord[0] >= 0 ? 1 : -1;
		var ddd = sign * ( absolute + ~~coord[1]/60 + ~~coord[2]/3600 ).toFixed(6);
		return ddd;
	}

	function dms_to_dmd (dms){
		var ddd = dms_to_ddd(dms);
		var dmd = ddd_to_dmd(ddd);
		return dmd;
	}

	function dmd_to_dms (dmd){
		var ddd = dmd_to_ddd(dmd);
		var dms = ddd_to_dms(ddd);
		return dms;
	}

	function dmd_to_ddd (dmd){
		var coord = dmd.split(":");
		var absolute = Math.abs(coord[0]);
		var sign = coord[0] >= 0 ? 1 : -1;
		var ddd = sign * ( absolute + coord[1]/60).toFixed(6);
		return ddd.toFixed(6);
	}

	function ddd_to_dms (deg) {
		var absolute = Math.abs(deg);
		var degrees = Math.floor(absolute);
		var minutesNotTruncated = (absolute - degrees) * 60;
		var minutes = Math.floor(minutesNotTruncated);
		var seconds = Math.floor((minutesNotTruncated - minutes) * 60);
		var sign = deg >= 0 ? "" : "-";

		return sign + degrees + ":" + minutes + ":" + seconds;
	}

	function ddd_to_dmd (deg) {
		var absolute = Math.abs(deg);
		var degrees = Math.floor(absolute);
		var minutes = ((absolute - degrees) * 60).toFixed(3);
		var sign = deg >= 0 ? "" : "-";

		return sign + degrees + ":" + minutes;
	}


	// Set up the Map. Begin Drawing at 0,0. 
	// 'map' and 'marker' are global objects that can be updated later

	var map = L.map('map').setView({lon: 175, lat: -38}, 4);


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

	// show the scale bar on the lower left corner
	L.control.scale().addTo(map);

	// show a marker on the map
	var marker = L.marker({lon: 175, lat: -38}).bindPopup('Landout').addTo(map);

	// Add Full Screen Button to Map
	map.addControl(new L.Control.Fullscreen());


	// Add Print Screen
	L.simpleMapScreenshoter().addTo(map);

	// Function to Refresh the map 

	function refresh_map (lat, lon) {

		map.setView({lon: lon, lat: lat}, 10);
		marker.setLatLng({lon: lon, lat: lat});
	}

</script>

<?php JSRegister::end(); ?>
