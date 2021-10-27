<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'GNZ Contest Manager';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h3><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-4">
				<h5>Start by Registering an Account</h5>
				<p><a class="btn btn-lg btn-primary" href="<?= Url::toRoute('/user/register') ?>">Sign Me Up &raquo;</a></p>
	</div>


</div>
