<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

$cookies = Yii::$app->request->cookies;
$theme = $cookies->getValue('theme_picker', 'name');
raoul2000\bootswatch\BootswatchAsset::$theme = $theme;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
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

		<div class="wrap">
			<?php
			NavBar::begin([
				'brandLabel' => Yii::$app->name,
				'brandUrl' => Yii::$app->homeUrl,
				'renderInnerContainer'=>false,
				'options' => [
					'class' => 'navbar-inverse navbar-fixed-top',
				],
			]);


			if (\Yii::$app->user->isGuest){
				$contest_id = 0;
			}
			else{
				$contest_id = \yii::$app->user->identity->profile->contest_id;
			}

			$contest = app\models\Contest::findOne(['id'=>$contest_id]);
			$contest = $contest->name ?? 'No Contest Selected';

			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-left navbar-active'],
				'encodeLabels' => false,
				'items' => [
					Yii::$app->user->isGuest ? ( ['label'=>'No Contest Selected']) : (['label'=> "<span class='btn btn-success navbar-btn' style='margin-top:0px; margin-bottom:0px; padding-top:0px; padding-bottom:0px'> $contest </span>", 'url' => ['/user/settings']]), 
				],
			]);

			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'Contest Management', 'visible'=>!Yii::$app->user->isGuest,
						'items'=> [
							['label' => 'Launches', 'url' => ['/launch/manage']],
							['label' => 'Aircraft Status', 'url' => ['/status/manage']],
							['label' => 'Aircraft Tracking', 'url' => ['/track']],
							['label' => 'Landouts', 'url' => ['/landout']],
							['label' => 'Aero Retrieves', 'url' => ['/retrieve/manage']],
							['label' => 'Accounts', 'url' => ['/transaction/manage']],
							['label' => 'SMS Messaging', 'url' => ['/sms']],
						],
					],
					['label' => 'Contest Admin', 'visible'=>Yii::$app->user->can('Administrator') or Yii::$app->user->can('Director') ,
						'items'=> [
							['label' => 'Setup a Contest', 'url'=>['/site/setup']],
							['label' => 'Clubs', 'url' => ['/club']],
							['label' => 'Contests', 'url' => ['/contest']],
							['label' => 'Towplanes', 'url' => ['/master-towplane']],
							['label' => 'Default Prices', 'url' => ['/default-type']],
							['label' => 'Contest Prices', 'url' => ['/transaction-type']],
							['label' => 'Contest Pilots', 'url' => ['/pilot']],
							['label' => 'Contest People', 'url' => ['/person']],
							['label' => 'Contest Towplanes', 'url' => ['/towplane']],
						],
					],
					['label' => 'User Admin', 'visible'=>Yii::$app->user->can('Administrator'),
						'items' => [
							['label'=>'Users', 'url' => ['/user/admin']],
							['label'=>'Roles', 'url' => ['/user/role/index']],
							['label'=>'Permissions', 'url' => ['/user/permission/index']],
							['label'=>'Rules', 'url' => ['/user/rules/index']],	
							['label'=>'GNZ Access Token', 'url' => ['/site/token']],								
						],
					],
					Yii::$app->user->isGuest ? (
						['label' => 'Login', 'url' => ['/user/login']]
					) : (
						'<li>'
						. Html::beginForm(['/user/logout'], 'post')
						. Html::submitButton(
							'Logout (' . Yii::$app->user->identity->username . ')',
							['class' => 'btn btn-link logout']
						)
						. Html::endForm()
						. '</li>'
					)
				],
			]);
			NavBar::end();
			?>

			<div class="container-fluid" style="padding-top:70px">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				<?= Alert::widget() ?>
				<?= $content ?>
			</div>
		</div>

		<footer class="footer">
			<div class="container fluid">
				<p class="pull-left">&copy; Lyon MacIntyre Ltd <?= date('Y') ?></p>

				<p class="pull-right"><?= Yii::powered() ?></p>
			</div>
		</footer>

	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>
