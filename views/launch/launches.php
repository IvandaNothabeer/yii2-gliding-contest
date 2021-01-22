<?php

use yii\helpers\Html;
use x1\dragula\Dragula;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Launch $model
*/

$this->title = Yii::t('models', 'Launch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Launch'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud launch-update">

<h1>
	<?= Yii::t('models', 'Launch List') ?>
	<small>
		<?=  Html::encode($date) ?>
	</small>
</h1>

<hr />

<div class ="row" >
	<!-- build Column of Draggable Pilot Registrations -->
	<div class = col-md-1>
		<h4>Pilot List</h4>
		<div class="list-group" id="pilot_list">
			<!-- standard HTML attribute : id = Glider Rego, Additional HTML data- element : data-pilot = $pilot-id  -->
			<?php foreach ($pilots as $pilot) echo "<li class='list-group-item list-group-item-success' id='$pilot->rego_short' data-pilot='$pilot->id'>$pilot->rego_short</li>"  ?>
		</div>
	</div>
	<div class = col-md-1>

	</div>
	<!-- build Columns of Droppable Towplane Registrations -->
	<?php 
	$panel_ids = ['#pilot_list'];
	foreach ($towplanes as $towplane)
	{
		$panel_ids[] = "#$towplane->rego";

		echo "<div class='col-md-1'>";
		echo	"<h4>$towplane->rego</h4>";
		echo	"<div class='well' style='min-height:45px; padding:0px; background-color:#808080'  id='$towplane->rego' data-towplane='$towplane->id' >";
		foreach ($launches as $launch) 
			if  ($launch->towplane_id == $towplane->id) echo "<li class='list-group-item list-group-item-success'  data-pilot='$launch->pilot_id'>".$launch->pilot->rego_short."</li>" ;
			echo	"</div>";
		echo "</div>";


	}
	?>
</div>

<?php JSRegister::begin(); ?>

<script>

	//  JQuery Handler for the Dragula Widget Events

	var handler = {};

	handler.dropped = function(el, container, source) {
		var towplane    = $(container).data('towplane');  // Container is the drop target . data-towplane holds the towplane ID
		var pilot 		= $(el).data('pilot');			  // el is the dropped element . data-pilot holds the Pilot ID

		if (source.id != container.id){
			console.log('launched towplane', towplane);
			console.log('launched pilot', pilot);
			$.ajax({
				url: 'add-launch',
				data: {
					towplane: towplane,
					pilot: pilot
				}	
			});

			if (source.id != 'pilot_list') {
				var from = $(source).data('towplane');   
				console.log('removed towplane', from);
				console.log('removed pilot', pilot);
				$.ajax({
					url: 'remove-launch',
					data: {
						towplane: from,
						pilot: pilot
					}	
				});
			}
		}
	}

	handler.removed = function(el, container, source) {
		var towplane    = $(source).data('towplane');	// Source is the drag source . data-towplane holds the towplane ID
		var pilot  		= $(el).data('pilot');			// el is the dropped element . data-pilot holds the Pilot ID

		if (source.id != 'pilot_list' ) { 
			console.log('removed towplane', towplane);
			console.log('removed pilot', pilot);
			$.ajax({
				url: 'remove-launch',
				data: {
					towplane: towplane,
					pilot: pilot
				}	
			});
		}
	}

</script>

<?php JSRegister::end(); ?>

<?= Dragula::widget([
	'containers' => $panel_ids,
	'options'    => [
		//'revertOnSpill' => false,
		'removeOnSpill' => true,
		'copy' => new \yii\web\JsExpression('function (el, source) {
			return source.id === "pilot_list"
		}'),
		'accepts' => new \yii\web\JsExpression('function (el, source) {
			return source.id !== "pilot_list"
		}'),
	],
	'drop'    => new \yii\web\JsExpression('handler.dropped'),  // Glider Launched
	'remove'  => new \yii\web\JsExpression('handler.removed'),  // Launch Deleted
]); ?>

