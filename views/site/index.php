<?php

/* @var $this yii\web\View */

$this->title = yii::$app->name;

if (yii::$app->user->identity)
{
	$contest = app\models\Contest::findOne(['id'=>yii::$app->user->identity->profile->contest_id]);
	$contest = $contest->name ?? 'No Contest Selected';
}
else {
	$contest = 'No Contest Selected';
}

?>
<div class="site-index">

	<div class="jumbotron">
		<h1>Contest Manager</h1>

		<p><a class="btn btn-lg btn-success" href="upload"><?= 'Upload Trace' ?>&raquo;</a></p>
	</div>

	<div class="body-content">

		<div class="row align-content-center">
			<div class="col-lg-2">
				<h2>Launches</h2>
				<p><a class="btn btn-lg btn-info" href="launch">Todays Launches &raquo;</a></p>
				<div class="list-group">
					<?php $launches = \yii\helpers\ArrayHelper::map(\app\models\Launch::find()->where(['=','date',date('Y-m-d')])->all(),'id','pilot.rego_short'); ?>
					<?php foreach ($launches as $key=>$value) echo  "<li class='list-group-item'>$value</li>"?>
				</div>
			</div>
			<div class="col-lg-2">
				<h2>Status</h2>
				<p><a class="btn btn-lg btn-info" href="status/manage">Glider Status &raquo;</a></p>
				<div class="list-group">
					<?php $launches = \yii\helpers\ArrayHelper::map(\app\models\Status::find()->all(),'pilot.rego_short', 'status'); ?>
					<?php foreach ($launches as $key=>$value) echo  "<li class='list-group-item'>$key  -  $value</li>"?>
				</div>
			</div>
			<div class="col-lg-2">
				<h2>Tracking</h2>
				<p><a class="btn btn-lg btn-info" href="track">Tracking Updates &raquo;</a></p>
			</div>
			<div class="col-lg-2">
				<h2>Landouts</h2>
				<p><a class="btn btn-lg btn-info" href="landout">Landouts &raquo;</a></p>
			</div>
			<div class="col-lg-2">
				<h2>Retrieves</h2>
				<p><a class="btn btn-lg btn-info" href="retrieve">Aero Retreives &raquo;</a></p>
			</div>
		</div>



	</div>
</div>
