<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 20.07.17
 * Time: 17:18
 */
return [
    'language'      => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class'        => yii\faker\FixtureController::class,
            //'fixtureDataPath' => '@tests/fixtures/fixtures',
            'templatePath' => '@tests/fixtures',
            //'namespace' => 'tests\fixtures',
        ],
    ],
    'components'    => [
        'db'         => [
            'class' => yii\db\Connection::class,
            'dsn' => \App\Helpers\Env::get('DB_DRIVER', 'mysql') . ':'
	            . 'host=' . \App\Helpers\Env::get('MYSQL_TEST_HOST', 'mariadb') . ';'
	            . 'port=' . \App\Helpers\Env::get('MYSQL_TEST_PORT', '3306') . ';'
	            . 'dbname=' . \App\Helpers\Env::get('MYSQL_TEST_DATABASE', 'bank_test'),
            'username'    => \App\Helpers\Env::get('MYSQL_TEST_USER', 'testUser'),
            'password'    => \App\Helpers\Env::get('MYSQL_TEST_PASSWORD', 'testPass'),
            'charset'     => 'utf8mb4',
            'tablePrefix' => \App\Helpers\Env::get('MYSQL_TEST_DB_PREFIX', 'minex_'),
        ],
        'mongodb' => [
	        'dsn'         => 'mongodb://'
		        . \App\Helpers\Env::get('MONGO_TEST_USERNAME', 'testUser') . ':'
		        . \App\Helpers\Env::get('MONGO_TEST_PASSWORD', 'testPass') . '@'
		        . \App\Helpers\Env::get('MONGO_TEST_HOST', 'mongodb') . ':'
		        . \App\Helpers\Env::get('MONGO_TEST_PORT', 27017) . '/'
		        . \App\Helpers\Env::get('MONGO_TEST_DB_NAME', 'testDb'),

        ],
        'mailer'     => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
