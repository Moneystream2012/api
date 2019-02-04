<?php
/**
 * @author Tarasenko Andrii
 * @date: 13.07.17
 */

return [
	'class' => yii\db\Connection::class,
	'dsn' => \App\Helpers\Env::get('DB_DRIVER', 'mysql') . ':'
		. 'host=' . \App\Helpers\Env::get('MYSQL_HOST', 'mariadb') . ';'
		. 'port=' . \App\Helpers\Env::get('MYSQL_PORT', '3306') . ';'
		. 'dbname=' . \App\Helpers\Env::get('MYSQL_DATABASE', 'bank_db'),
	'username'    => \App\Helpers\Env::get('MYSQL_USER', 'user'),
	'password'    => \App\Helpers\Env::get('MYSQL_PASSWORD', 'pass'),
    'charset'     => 'utf8mb4',
	'tablePrefix' => \App\Helpers\Env::get('MYSQL_DB_PREFIX', 'minex_'),

    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 86400,
    'schemaCache' => 'mysqlRedisCache',
    'queryCache' => 'mysqlRedisCache',

];
