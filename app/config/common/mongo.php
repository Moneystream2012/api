<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 27.07.17
 */

return [
    'class'       => yii\mongodb\Connection::class,
    'dsn'         => 'mongodb://'
	    . \App\Helpers\Env::get('MONGO_USERNAME', 'user') . ':'
	    . \App\Helpers\Env::get('MONGO_PASSWORD', 'pass') . '@'
	    . \App\Helpers\Env::get('MONGO_HOST', 'mongodb') . ':'
	    . \App\Helpers\Env::get('MONGO_PORT', 27017) . '/'
	    . \App\Helpers\Env::get('MONGO_DB_NAME', 'admin'),
];