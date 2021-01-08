<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Contest Setup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contest-setup">
<h1><?= Html::encode($this->title) ?></h1>


<div class="body-content">

	<div class="row align-content-center">
		<div class="col-md-2">
			<h2>Contests</h2>
			<p><a class="btn btn-lg btn-info" href="<?= Url::toRoute('/contest/create') ?>">Create A Contest &raquo;</a></p>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $contests = \yii\helpers\ArrayHelper::map(\app\models\Contest::findEvery()->all(),'id','name'); ?>
					<?php foreach ($contests as $key=>$value) echo ($key == \yii::$app->user->identity->profile->contest_id) ? "<li class='list-group-item active'>$value</li>" : "<li class='list-group-item'>$value</li>"?>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<h2>Prices</h2>
			<p><a class="btn btn-lg btn-info" href="<?= Url::toRoute('/transaction-type') ?>">Setup the Prices &raquo;</a></p>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $prices = \yii\helpers\ArrayHelper::map(\app\models\TransactionType::find()->all(),'name','price'); ?>
					<?php foreach ($prices as $key=>$value) echo "<li class='list-group-item'>$key  - $ $value</li>" ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<h2>Towplanes</h2>
			<p><a class="btn btn-lg btn-info" href="<?= Url::toRoute('/towplane/create') ?>">Setup the Towplanes &raquo;</a></p>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $towplanes = \yii\helpers\ArrayHelper::map(\app\models\Towplane::find()->all(),'rego','name'); ?>
					<?php foreach ($towplanes as $key=>$value) echo "<li class='list-group-item'>$key  -  $value</li>" ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<h2>Pilots</h2>
			<p><a class="btn btn-lg btn-info" href="<?= Url::toRoute(['/contest/import', 'id'=>\yii::$app->user->identity->profile->contest_id]) ?>">Import the Pilot Entries &raquo;</a></p>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $pilots = \yii\helpers\ArrayHelper::map(\app\models\Pilot::find()->all(),'rego_short','name'); ?>
					<?php foreach ($pilots as $key=>$value) echo "<li class='list-group-item'>$key  -  $value</li>" ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<h2>People</h2>
			<p><a class="btn btn-lg btn-info" href="<?= Url::toRoute(['/person/create', 'Person' => ['contest_id'=>\yii::$app->user->identity->profile->contest_id]]) ?>">Add Extra People &raquo;</a></p>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php $people = \yii\helpers\ArrayHelper::map(\app\models\Person::find()->all(),'role','name'); ?>
					<?php foreach ($people as $key=>$value) echo "<li class='list-group-item'>$key  -  $value</li>" ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<h2>SMS List</h2>
			<p><a class="btn btn-lg btn-info" href="<?= Url::toRoute(['/sms/synch-sms', 'contest_id'=>\yii::$app->user->identity->profile->contest_id]) ?>">Create the SMS Contact List &raquo;</a></p>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
					$lists = \yii\helpers\ArrayHelper::map(\yii::$app->sms->getLists(),'list_id','list_name'); ?>
					<?php foreach ($lists as $key=>$value) echo ($value == @\app\models\Contest::find()->one()->name) ? "<li class='list-group-item'>$value</li>" : "" ?>
				</div>
			</div>
		</div>
	</div>





</div>
