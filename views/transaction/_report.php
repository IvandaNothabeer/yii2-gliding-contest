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
			<table width="100%" align="MIDDLE">
				<tr>
					<td>
						<h3><?= $contest->name ?></h3>
					</td>
					<td>
						<h3> Invoice To: </h3>
					</td>
				</tr>
				<tr>
					<td>
						<h3><?= $club->name ?></h3>
					</td>
					<td>
						<h3><?= $person->name ?></h3>
					</td>
				</tr>
				<tr>
					<td>
						<p><?= $club->address1 ?></p>
					</td>
					<td>
						<p><?= $person->address1 ?></p>
					</td>
				</tr>
				<tr>
					<td>
						<p><?= $club->address2 ?></p>
					</td>
					<td>
						<p><?= $person->address2 ?></p>
					</td>
				</tr>
				<tr>
					<td>
						<p><?= $club->address3 ?></p>
					</td>
					<td>
						<p><?= $person->address3 ?></p>
					</td>
				</tr>
				<tr>
					<td>
						<p><?= $club->postcode ?></p>
					</td>
					<td>
						<p><?= $person->postcode ?></p>
					</td>
				</tr>
				<br>
				<tr>
					<td>
						<h4>Payment Details</h4>
					</td>
				</tr>
				<tr>
					<td>
						<p>Bank Name : <?= $club->bankname ?></p>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<p>Bank Account : <?= $club->bankno ?></p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Bank Reference : Your Name</p>
					</td>
				</tr>>
				<tr>
					<td>
						<p>Club Email : <?= $club->email ?></p>
					</td>
				</tr>>
				</tr>
			</table>



			<p></p>
			<p></p>

			<div class="table-responsive">
				<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
					'headerRowOptions' => ['class' => 'x'],
					'options' => ['style' => 'font-size:10px;'],
					'showPageSummary' => true,
					'columns' => [
						'date',
						[
							'class' => \kartik\grid\DataColumn::class,
							'attribute' => 'type_id',
							'value' => function ($model) {
								if ($rel = $model->type) {
									return $rel->name;
								} else {
									return '';
								}
							},
							'format' => 'raw',
							'pageSummary' => 'Total Due',
						],
						'details',
						'quantity',
						'item_price',
						//'amount',
						[
							'class' => \kartik\grid\DataColumn::class,
							'attribute' => 'amount',
							'pageSummary' => function ($summary, $data, $widget) {
								return '$ ' . @number_format($summary, 2);
							},
							'pageSummaryFunc' => Gridview::F_SUM,
						],
					]
				]); ?>
			</div>
		</div>
	</div>
</body>

</html>