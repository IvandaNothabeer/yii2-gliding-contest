<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Landout $model
*/

$this->title = Yii::t('models', 'Landout');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Landouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud landout-create">

	<h1>
		<?= Yii::t('models', 'Landout') ?>
		<small>
			<?= Html::encode($model->id) ?>
		</small>
	</h1>

	<hr />

	<?= $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
