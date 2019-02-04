<?php
/**
 * @author Tarasenko Andrii
 * @date: 20.10.17
 */

/**
 * Application configuration for acceptance tests
 */

return yii\helpers\ArrayHelper::merge(
    require(APP_ROOT . 'config/cli/cli.php'),
    require(APP_ROOT . 'config/tests/config.php'),
    [
        'components' => [
            'request' => [
                // it's not recommended to run functional tests with CSRF validation enabled
                'enableCsrfValidation' => false,
                // but if you absolutely need it set cookie domain to localhost
                /*
                'csrfCookie' => [
                    'domain' => 'localhost',
                ],
                */
            ],
            'log'              => [
                'logger' => [
                    'class' => \Codeception\Lib\Connector\Yii2\Logger::class,
                    'traceLevel'  => 3,
                ]
            ],
        ],
    ]
);
