<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 13.11.17
 * Time: 15:42
 */

return [
    'class'    => \App\Components\Rpc::class,
    'host'     => \App\Helpers\Env::get('MINEXNODE_HOST', 'php'),
    'port'     => \App\Helpers\Env::get('MINEXNODE_PORT', 17786),
    'username' => \App\Helpers\Env::get('MINEXNODE_USER', 'user'),
    'password' => \App\Helpers\Env::get('MINEXNODE_PASS', 'password'),

    'proto'         => 'http',
    'url'           => '',
    'CACertificate' => null,
    'curlTimeout'   => 30, //30 sec
];
