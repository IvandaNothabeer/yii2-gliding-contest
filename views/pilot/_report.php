<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

?>

<?php


?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->registerCsrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>
		<div class="container">
			<div class="body-content">
				<h3><?= $contest->name ?></h3>

				<div class="table-responsive">
					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
						'headerRowOptions' => ['class'=>'x'],
						'options' => ['style' => 'font-size:10px;'],
						'showPageSummary' => true,
						'columns' => [
							'rego_short',
							'name',
						]
					]); ?>
				</div>
			</div>
		</div>
	</body>
</html>
