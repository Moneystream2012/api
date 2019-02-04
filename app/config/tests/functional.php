<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 20.07.17
 * Time: 17:19
 */
/*$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;
$_SERVER['PHP_SELF'] = YII_TEST_ENTRY_URL;*/

/**
 * Application configuration for functional tests
 */

return yii\helpers\ArrayHelper::merge(
    require(APP_ROOT . 'config/web/web.php'),
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
