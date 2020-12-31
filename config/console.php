<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
	'id' => 'basic-console',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'app\commands',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
		'@tests' => '@app/tests',
	],
	'timeZone' => 'Pacific/Auckland',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $db,
		'i18n' => [
			'translations' => [
				'*' => [
					'class'          => 'yii\i18n\PhpMessageSource',
					'basePath'       => '@app/messages', // if advanced application, set @frontend/messages
					'sourceLanguage' => 'en',
					'fileMap'        => [
						//'main' => 'main.php',
					],
				],
			],
		],
	],
	'modules' => [
		'user' => [
			'class' => Da\User\Module::class,
			'classMap' => [
				'User' => app\models\User::class,
				'Profile' => app\models\Profile::class,
			],
			'enableEmailConfirmation' => false,
			'allowUnconfirmedEmailLogin' => true,
			// ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
			'administrators' => ['admin'], // this is required for accessing administrative actions
			// 'generatePasswords' => true,
			'switchIdentitySessionKey' => 'dfv2345fshfbnetn424689',
		]
	],
	'params' => $params,
	'controllerMap' => [
		'batch' => [
			'class' => 'schmunk42\giiant\commands\BatchController',
			'overwrite' => true,
			'enableI18N' => false,
			'modelNamespace' => '\app\models',
			'modelQueryNamespace' => '\app\models\query',
			'crudSearchModelNamespace' => '\app\models\search',
			'crudControllerNamespace' => '\app\controllers',
			'crudViewPath' => 'views',
			'modelGenerateLabelsFromComments' => true,
			'modelGenerateHintsFromComments' => false,
			'crudPathPrefix' => '',
			'crudTidyOutput' => true,
			'crudFixOutput' => true,
			'crudActionButtonColumnPosition' => 'right', //left by default
			'crudAccessFilter' => true,
			'generateAccessFilterMigrations' => false,
			'crudTemplate' => 'default',
			'crudFormLayout' => 'horizontal',
			//'crudIndexGridClass' => 'kartik\grid\GridView',
			'crudProviders' => [
				\schmunk42\giiant\generators\crud\providers\core\OptsProvider::className(),
				\schmunk42\giiant\generators\crud\providers\core\CallbackProvider::className(),
				\schmunk42\giiant\generators\crud\providers\core\RelationProvider::className(),
			],
			'tablePrefix' => '',
			'tables' => [
				'clubs',
				'contests',
				'pilots',
				'transactionTypes',
				'defaultTypes',
				'transactions',
				'launches',
				'retrieves',
				'towplanes',
			],
			'interactive' => false,
		],
		'migrate' => [
			'class' => \yii\console\controllers\MigrateController::class,
			'migrationPath' => [
				'@app/migrations',
				'@yii/rbac/migrations', // Just in case you forgot to run it on console (see next note)
			],
			'migrationNamespaces' => [
				'Da\User\Migration',
			],
		],
	],
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
	];
}

return $config;
