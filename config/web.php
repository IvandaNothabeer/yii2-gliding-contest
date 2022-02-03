<?php

use \kartik\datecontrol\Module;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
	'id' => 'basic',
	'name' => "GNZ Contest Manager",
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'timeZone' => 'Pacific/Auckland',
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'eeripICD90ettVb8CshE8T9ftqEGeu0X',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
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
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $db,
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
		'i18n' => [
			'translations' => [
				'*' => [
					'class'          => 'yii\i18n\PhpMessageSource',
					'basePath'       => '@app/messages', // if advanced application, set @frontend/messages
					'sourceLanguage' => 'en-US',
				],
			],
		],
		'gnz' => [
			'class' => 'app\components\gnzInterfaceComponent',
		],
		'sms' => [
			'class' => 'app\components\smsInterfaceComponent',
		],
		'view' => [
			'theme' => [
				'pathMap' => [
					'@Da/User/resources/views' => '@app/views/user'
				]
			]
		],
	],
	'modules' => [
		'user' => [
			'class' => Da\User\Module::class,
			'classMap' => [
				'User' => app\models\User::class,
				'Profile' => app\models\Profile::class,
			],
			// ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
			'administrators' => ['admin'], // this is required for accessing administrative actions
			// 'generatePasswords' => true,
			// 'switchIdentitySessionKey' => 'myown_usuario_admin_user_key',
			'enableEmailConfirmation' => false,
			'allowUnconfirmedEmailLogin' => true,
		],
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		],
		'datecontrol' =>  [
			'class' => '\kartik\datecontrol\Module',
			// format settings for displaying each date attribute (ICU format example)
			'displaySettings' => [
				Module::FORMAT_DATE => 'dd-MM-yyyy',
				Module::FORMAT_TIME => 'hh:mm:ss a',
				Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a', 
			],

			// format settings for saving each date attribute (PHP format example)
			'saveSettings' => [
				Module::FORMAT_DATE => 'php:Y-m-d', 
				Module::FORMAT_TIME => 'php:H:i:s',
				Module::FORMAT_DATETIME => 'php:U', // saves as unix timestamp
			],

			// set your display timezone
			'displayTimezone' => 'Pacific/Auckland',

			// set your timezone for date saved to db
			'saveTimezone' => 'UTC',

			// automatically use kartik\widgets for each of the above formats
			'autoWidget' => true,

			// default settings for each widget from kartik\widgets used when autoWidget is true
			'autoWidgetSettings' => [
				Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
				Module::FORMAT_DATETIME => [], // setup if needed
				Module::FORMAT_TIME => [], // setup if needed
			],

			// custom widget settings that will be used to render the date input instead of kartik\widgets,
			// this will be used when autoWidget is set to false at module or widget level.
			'widgetSettings' => [
				Module::FORMAT_DATE => [
					'class' => 'yii\jui\DatePicker', // example
					'options' => [
						'dateFormat' => 'php:d-M-Y',
						'options' => ['class'=>'form-control'],
					]
				]
			]
			// other settings
		],
	],
	'container' => [
        'definitions' => [
            yii\grid\DataColumn::class => [
				'filterInputOptions' => ['placeholder' => 'Search', 'class' => 'form-control'],
            ],
        ],
    ],
	'params' => $params,
	'language' => 'en-NZ',
	'sourceLanguage' => 'en-US',
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		//'allowedIPs' => ['127.0.0.1', '::1'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		//'allowedIPs' => ['127.0.0.1', '::1'],
	];
}

return $config;
