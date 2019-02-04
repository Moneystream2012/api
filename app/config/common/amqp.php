<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 20.07.17
 * Time: 17:40
 */
return [
	'host'     => \App\Helpers\Env::get('RABBITMQ_HOST', 'rabbitmq'),
	'port'     => \App\Helpers\Env::get('RABBITMQ_PORT', 5672),
	'user'     => \App\Helpers\Env::get('RABBITMQ_DEFAULT_USER', 'user'),
	'password' => \App\Helpers\Env::get('RABBITMQ_DEFAULT_PASSWORD', 'pass'),
	'vhost'    => \App\Helpers\Env::get('RABBITMQ_VHOST', '/'),
];
