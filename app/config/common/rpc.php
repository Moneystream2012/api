<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date 08.08.17
 */

return [
    'class'    => \App\Components\Rpc::class,
    'host'     => \App\Helpers\Env::get('MINEXNODE_CLUSTER_HOST', '138.197.186.81'),
    'port'     => \App\Helpers\Env::get('MINEXNODE_CLUSTER_PORT', 80),
    'username' => \App\Helpers\Env::get('MINEXNODE_CLUSTER_USER', 'root'),
    'password' => \App\Helpers\Env::get('MINEXNODE_CLUSTER_PASS', 'Hd54ldfmz8mpwqmH'),

    'proto'         => 'http',
    'url'           => '',
    'CACertificate' => null,
    'curlTimeout'   => 30, //30 sec
];