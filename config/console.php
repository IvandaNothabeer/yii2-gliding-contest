<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
	'id' => 'basic-console',
	'basePath' => dirname(__DIR__),
	'bootstrap' => [
		'log',
		'queue'
	],
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
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => $params['adminEmail'],
                'password' => $params['gmailPassword'],
            ],
		],
		'gnz' => [
			'class' => 'app\components\gnzInterfaceComponent',
		],
		'sms' => [
			'class' => 'app\components\smsInterfaceComponent',
		],
		'queue' => [
			'class' => \yii\queue\file\Queue::class,
			'path' => '@runtime/queue',
            // Other driver options
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
				\schmunk42\giiant\generators\crud\providers\core\OptsProvider::class,
				\schmunk42\giiant\generators\crud\providers\core\CallbackProvider::class,
				\schmunk42\giiant\generators\crud\providers\core\RelationProvider::class,
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
				'@yii/rbac/migrations', 
				'@vendor/sammaye/yii2-audittrail/migrations',
			],
			'migrationNamespaces' => [
				'Da\User\Migration',
			],
		],
		'migration' => [
			'class' => 'bizley\migration\controllers\MigrationController',
			'excludeTables' => ['auth_assignment','auth_item','auth_item_child','auth_rule','social_account','token', 'profile','user'],
			'skipMigrations' => ['Person_access','MasterTowplane_access']
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
