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
	<?= '' //Yii::t('models', 'Launch') ?>
	<small>
		<?= '' //Html::encode($model->id) ?>
	</small>
</h1>

<div class="crud-navigation">
	<?= '' //Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
</div>

<hr />

<div class ="row" >
<div class = col-md-1>
	<h3>Pilots</h3>
	<div class="panel panel-default" id="pilot_panel">
		<div class="panel-body"  id="pilot_list">
			<li class=list-group-item>TT</li>
			<li class=list-group-item>KT</li>
			<li class=list-group-item>SW</li>
		</div>
	</div>
</div>
<div class='col-md-1'>
	<h3>TPO</h3>
	<div class="panel panel-default" id="tug1-panel">
		<div class="panel-body">
		</div>
	</div>
</div>
<div class='col-md-1'>
	<h3>TZB</h3>
	<div class="panel panel-default" id="tug2-panel">
		<div class="panel-body">
		</div>
	</div>
</div>


<?php 
//echo $this->render('_form', [
//'model' => $model,
//]);

?>

<?= Dragula::widget([
	'containers' => ['#pilot_list', '#tug1-panel', '#tug2-panel'],
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