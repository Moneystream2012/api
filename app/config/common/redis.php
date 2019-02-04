<?php
return [
    'class'    => yii\redis\Connection::class ,
    'hostname' => \App\Helpers\Env::get('REDIS_HOST', 'redis'),
    'port'     => \App\Helpers\Env::get('REDIS_PORT', 6379),
    'database' => \App\Helpers\Env::get('REDIS_DB', 2),
];