<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 20.07.17
 * Time: 17:37
 */

$config = [
    'id'          => 'bank-api',
    'basePath'    => APP_ROOT . 'src/',
    'vendorPath'  => APP_ROOT . 'vendor/',
    'runtimePath' => APP_ROOT . 'storage/runtime/',

    'bootstrap'           => ['log'],
    'controllerNamespace' => 'App\Commands',
    'components'          => [
        'cache' => yii\caching\FileCache::class,
        'sentry' => [
	        'class' => mito\sentry\Component::class,
	        'dsn' => 'https://9d92a6c091204ce39769fbf8bbc76902:35f73eb1e0e84e7fac2377b6c69c9afe@sentry.io/222788',
	        'environment' => YII_ENV.'_cli', // if not set, the default is `production`
	        'enabled' => YII_ENV_DEV ? false : true
        ],

        'mysqlRedisCache' => yii\redis\Cache::class,

        'log'   => [
	        'traceLevel' => 3,
	        'flushInterval' => 1,
	        'targets' => [
		        [
			        'class' => pahanini\log\ConsoleTarget::class,
			        'levels' => YII_ENV_DEV ?
                        [
                            'error',
                            'warning',
                            'info',
                            'trace',
                            'profile'
                        ] : [
                            'error',
                            'warning',
                            'info'
                        ],
			        'displayCategory' => true,
			        'displayDate' => true,
			        'exportInterval' => 1,
			        'except' => [
				        'yii\db\*',
				        'yii\base\*',
				        'yii\base\View::renderFile',
				        'yii\redis\Connection::*'
			        ],
		        ],

		        [
			        'class' => mito\sentry\Target::class,
			        'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\debug\Module::checkAccess',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:405',
                        'yii\web\HttpException:401',
                    ],
		        ],
                [
                    'class' => yii\log\FileTarget::class,
                    'logFile' => '@runtime/logs/cli.log',
                    'levels' => YII_ENV_DEV ? ['error', 'warning', 'info', ] : ['error', 'warning'],
                    'fileMode' => 0664,
                    'except' => [
                        'yii\debug\Module::checkAccess',
                        '\yii\redis\Connection'
                    ],
                ]
	        ],
        ],
        'user'       => [
            'class'           => \App\Modules\User\Components\WebUser::class,
            'identityClass' => \App\Modules\User\Components\AbstractIdentity::class, // User must implement the IdentityInterface
            'enableAutoLogin' => true,
            'enableSession'   => false,
            'loginUrl'        => null
        ],
        'i18n'       => [
            'translations' => [
                '*' => [
                    'class' => yii\i18n\DbMessageSource::class,
                    'db'    => 'db'
                ],
            ],
        ],
        'mailer'          => [
            'class'            => yii\swiftmailer\Mailer::class,
            'viewPath'         => '@app/Modules/Notification/Mail',
            'htmlLayout'       => 'layouts/html.php',
            'textLayout'       => 'layouts/text.php',

            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => \App\Helpers\Env::get('mailDebug', true),
            'transport'        => [
                'class'      => \App\Helpers\Env::get('mailClass', ''),
                'host'       => \App\Helpers\Env::get('mailHost', ''),
                'username'   => \App\Helpers\Env::get('mailLogin', ''),
                'password'   => \App\Helpers\Env::get('mailPassword', ''),
                'port'       => \App\Helpers\Env::get('mailPort', '587'),
                'encryption' => \App\Helpers\Env::get('mailEncryption', 'tls'),
            ],
        ],
        'db'        => include APP_ROOT . 'config/common/db.php',
        'mongodb'   => require APP_ROOT . 'config/common/mongo.php',
        'redis'     => require APP_ROOT . 'config/common/redis.php',
        'rpc'       => require APP_ROOT . 'config/common/rpc.php',
        'localRpc'       => require APP_ROOT . 'config/common/localRpc.php',
        'minexnode' => require APP_ROOT . 'config/common/minexnode.php',
        'localMinexnode' => require APP_ROOT . 'config/common/localMinexnode.php',
        'authManager' => require APP_ROOT . 'config/common/authManager.php',
        'amqpRPCClient' => \App\Helpers\Arr::merge(require APP_ROOT . 'config/common/amqp.php', [
        	'class' => \App\Components\Amqp\AmqpRPCClient::class
        ]),

        'formatter'       => [
            'class'          => yii\i18n\Formatter::class,
            'dateFormat'     => 'Y-M-d',
            'datetimeFormat' => \App\Components\BaseModel::DB_DATE_TIME_FORMAT,
            'timeFormat'     => 'H:i:s',
        ],
    ],
    'modules'   => [
        'finance' => App\Modules\Finance\FinanceModule::class,
        'explorer' => \App\Modules\Explorer\ExplorerModule::class,
        'notification' => \App\Modules\Notification\NotificationModule::class,
        'subscribe' => \App\Modules\Subscribe\SubscribeModule::class,
        'user' => \App\Modules\User\UserModule::class
    ],
    'params'              => include APP_ROOT . 'config/common/params.php',
    'controllerMap'       => [
        'migrate' => [
            'class'         => \yii\console\controllers\MigrateController::class,
            'migrationPath' => ['@App/Migrations', '@yii/rbac/migrations'],
        ],
        'explorer' => [
            'class' => \App\Modules\Explorer\Commands\ExplorerController::class
        ],
        'payout' => [
            'class' => \App\Modules\Finance\Commands\PayoutController::class
        ]
    ],
];


// configuration adjustments for 'dev' environment
$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'generators' => [
	    'model' => [
		    //'class'                      => \App\Components\Gii\ModelGenerator::class,
		    'class'                      => \yii\gii\generators\model\Generator::class,
		    'useTablePrefix'             => true,
		    'generateLabelsFromComments' => true,
		    'enableI18N'                 => true,
		    'queryNs'                    => 'App\Modules\Database',
		    'ns'                         => 'App\Modules\Database',
		    'baseClass'                  => App\Components\BaseModel::class
	    ]
    ],
];
return $config;
