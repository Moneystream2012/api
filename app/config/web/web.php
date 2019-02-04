<?php

$config = [
    'id'                  => 'bank-api',
    'basePath'            => APP_ROOT . 'src/',
    'vendorPath'          => APP_ROOT . 'vendor/',
    'runtimePath'         => APP_ROOT . 'storage/runtime/',
    'controllerNamespace' => 'App\Controllers',
    'bootstrap'           => [
        'log'
    ],
    'components'          => require __DIR__ . '/components.php',
    'modules'             => require __DIR__ . '/modules.php',
    'params'              => require APP_ROOT . 'config/common/params.php'
];
if (\App\Helpers\Env::get('GII_ENABLED', true)) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => yii\gii\Module::class,
        'allowedIPs' => explode(',', \App\Helpers\Env::get('GII_IPS', '127.0.0.1,::1,*')),
        'generators' => [
            'model' => [
                'class'     => 'yii\gii\generators\model\Generator',
                'queryNs'   => 'App\Modules\Database',
                'ns'        => 'App\Modules\Database',
                'baseClass' => App\Components\BaseModel::class
            ],
            'fixtureClass'=>['class'=>\insolita\fixturegii\generators\ClassGenerator::class,],
            'fixtureData'=>['class'=>\insolita\fixturegii\generators\DataGenerator::class,],
            'fixtureTemplate'=>[
                'class'=>\insolita\fixturegii\generators\TemplateGenerator::class,
                'tplPath' => '@tests/fixtures/data',
            ],
        ],
    ];
}
if (\App\Helpers\Env::get('DEBUG_PANEL_ENABLED', true)) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'       => yii\debug\Module::class,
        'historySize' => 20000,
        'dataPath'    => \App\Helpers\Env::get('DEBUG_PANEL_STORAGE_FOLDER', '@runtime/debug'),
        'allowedIPs'  => explode(',', \App\Helpers\Env::get('DEBUG_PANEL_IPS', '127.0.0.1,::1,*')),
    ];
}
return $config;