<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 20.07.17
 * Time: 17:19
 *
 * Application configuration for unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(APP_ROOT . 'config/web/web.php'),
    require(APP_ROOT . 'config/tests/config.php'),
    [
        'id' => '2'
    ]
);
