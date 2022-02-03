<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Sms $model
 */
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Sms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud sms-view">

	<!-- flash message -->
	<?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
		<span class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			<?= \Yii::$app->session->getFlash('deleteError') ?>
		</span>
	<?php endif; ?>

	<h1>
		<?= Yii::t('models', 'Sms') ?>
		<small>
			<?= Html::encode($model->id) ?>
		</small>
	</h1>


	<div class="clearfix crud-navigation">

		<!-- menu buttons -->


	</div>

	<hr />

	<?php $this->beginBlock('\app\models\Sms'); ?>


	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'from',
			'sender_id',
			'sent',
			'received',
			'message:ntext',
			'sender',
		],
	]); ?>


	<hr />

	<?= Html::a(
		'<span class="glyphicon glyphicon-trash"></span> ' . 'Delete',
		['delete', 'id' => $model->id],
		[
			'class' => 'btn btn-danger',
			'data-confirm' => '' . 'Are you sure to delete this item?' . '',
			'data-method' => 'post',
		]
	); ?>
	<?php $this->endBlock(); ?>



	<?= Tabs::widget(
		[
			'id' => 'relation-tabs',
			'encodeLabels' => false,
			'items' => [
				[
					'label'   => '<b class=""># ' . Html::encode($model->id) . '</b>',
					'content' => $this->blocks['\app\models\Sms'],
					'active'  => true,
				],
			]
		]
	);
	?>
</div>