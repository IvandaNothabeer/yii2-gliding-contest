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
//$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud launch-update">

<h1>
	<?= Yii::t('models', 'Launch List') ?>
	<small>
		<?=  Html::encode($date) ?>
	</small>
</h1>

<div class="crud-navigation">
	<?= '' //Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
</div>

<hr />

<div class ="row" >
	<!-- build Column of Draggable Pilot Registrations -->
	<div class = col-md-1>
		<h4>Pilot List</h4>
		<div class="list-group" id="pilot_list">
				<?php foreach ($pilots as $pilot) echo "<li class='list-group-item list-group-item-success' id='$pilot->rego_short'>$pilot->rego_short</li>"  ?>
		</div>
	</div>
	<!-- build Columns of Droppable Towplane Registrations -->
	<?php 
	$panel_ids = ['#pilot_list'];
	foreach ($towplanes as $towplane)
	{
		$panel_ids[] = "#$towplane->rego"."_panel";
		
		echo "<div class='col-md-1'>";
		echo	"<h4>$towplane->rego</h4>";
		echo	"<div class='well well-sm' id='$towplane->rego"."_panel'>";
		echo	"</div>";
		echo "</div>";
		
		
	}
	?>
</div>

<?php 
//echo $this->render('_form', [
//'model' => $model,
//]);

?>

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
	//'drop' => new \yii\web\JsExpression('my.dropped'),
]); ?>



<?php JSRegister::begin(); ?>

<script>

</script>

<?php JSRegister::end(); ?>