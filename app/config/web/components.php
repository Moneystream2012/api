<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 17.07.17
 * Time: 17:46
 */

use App\Helpers\Env;

return [
    'db' => require APP_ROOT . 'config/common/db.php',
    'mongodb' => require APP_ROOT . '/config/common/mongo.php',
    'redis'   => require APP_ROOT . '/config/common/redis.php',

    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'hsers656ejdfs&i6EUREFSTY54WUWrset56U',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ]
    ],
    'cache' => yii\caching\FileCache::class,

    'sentry' => [
        'class' => mito\sentry\Component::class,
        'dsn' => 'https://9d92a6c091204ce39769fbf8bbc76902:35f73eb1e0e84e7fac2377b6c69c9afe@sentry.io/222788',
        'environment' => YII_ENV.'_web', // if not set, the default is `production`
        'enabled' => YII_ENV_DEV ? false : true
    ],

    'mailgun' => [
        'class' => \App\Components\MailgunClient::class,
        'apiKey' => 'key-443be68c2186361c1b189ba19a538355'
    ],

    'mysqlRedisCache' => yii\redis\Cache::class,

    'log'   => [
        'traceLevel' => 3,
        'targets' => [
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
                'logFile' => '@runtime/logs/web.log',
                'levels' => YII_ENV_DEV
                    ? [
                        'error',
                        'warning',
                        'info',
                        'trace',
                        'profile'
                    ]
                    : [
                        'error',
                        'warning'
                    ],
                'except' => [
                    'yii\debug\Module::checkAccess',
                ],
            ]
        ],
    ],

//    'errorHandler' => [
//        'class'             => \App\Components\ErrorHandler\Handler::class,
//        'overwriteActive'   => true,
//        'displayStacktrace' => true
//    ],

    'urlManager' => [
        'class' => \yii\web\UrlManager::class,
        'baseUrl' => Env::get('baseUrl', '/api/'),
        'showScriptName' => false,
        'enablePrettyUrl' => true,
        'rules' => require APP_ROOT . 'config/common/routes.php'
    ],
    'user'       => [
        'class'           => \App\Modules\User\Components\WebUser::class,
        'identityClass' => \App\Modules\User\Components\AbstractIdentity::class, // User must implement the IdentityInterface
        'enableAutoLogin' => false,
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
    'reCaptcha'  => [
        'name'    => 'reCaptcha',
        'class'   => himiklab\yii2\recaptcha\ReCaptcha::class,
        'siteKey' => 'foo',
        'secret'  => 'foo',
    ],

    'mailer'          => [
        'class'            => yii\swiftmailer\Mailer::class,
        'viewPath'         => '@app/Modules/Notification/Mail',
        'htmlLayout'       => 'layouts/html.php',
        'textLayout'       => 'layouts/text.php',

        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => Env::get('mailDebug', false),
        'transport'        => [
            'class'      => Env::get('mailClass', ''),
            'host'       => Env::get('mailHost', ''),
            'username'   => Env::get('mailLogin', ''),
            'password'   => Env::get('mailPassword', ''),
            'port'       => Env::get('mailPort', '587'),
            'encryption' => Env::get('mailEncryption', 'tls'),
        ],
    ],
    'formatter'       => [
        'class'          => yii\i18n\Formatter::class,
        'dateFormat'     => 'Y-M-d',
        'datetimeFormat' => \App\Components\BaseModel::DB_DATE_TIME_FORMAT,
        'timeFormat'     => 'H:i:s',
    ],
    'assetManager' => [
        'class' => \yii\web\AssetManager::class,
        'baseUrl' => '@web' . Env::get('APP_BASE_URL', '/') . 'assets'
    ],

    'rpc'       => require APP_ROOT . 'config/common/rpc.php',
    'localRpc'       => require APP_ROOT . 'config/common/localRpc.php',
    'minexnode' => require APP_ROOT . 'config/common/minexnode.php',
    'localMinexnode' => require APP_ROOT . 'config/common/localMinexnode.php',
    //'amqp'      => require APP_ROOT . 'config/common/amqp.php',
    'amqpRPCClient'=> \App\Helpers\Arr::merge(require APP_ROOT . 'config/common/amqp.php',[
        'class' => \App\Components\Amqp\AmqpRPCClient::class
    ]),
	'authManager' => require APP_ROOT . 'config/common/authManager.php',

    'liveChatApi' => [
	    'class' => \App\Modules\Chat\Components\LiveChatApi\LiveChatApi::class,
	    'login' => 'a.naidovskiy@minexsystems.com',
	    'apiKey' => 'ee295cb56d5507d5a71a858b637b63f4',
	    'license' => '9154540'
    ],

    'liveChat' => [
        'class' => \App\Modules\Chat\Components\LiveChat\LiveChat::class
    ],

];
