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
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud launch-update">

<h1>
	<?= Yii::t('models', 'Launch') ?>
	<small>
		<?= Html::encode($model->id) ?>
	</small>
</h1>

<div class="crud-navigation">
	<?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
</div>

<hr />

<?php 
echo $this->render('_form', [
	'model' => $model,
]);
?>

