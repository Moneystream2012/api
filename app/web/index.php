<?php
// @codingStandardsIgnoreStart
define("APP_ROOT",dirname(__FILE__ ).'/../');
if(!file_exists(APP_ROOT . 'vendor/autoload.php'))
{
	die('Library not loaded');
}

require APP_ROOT . 'vendor/autoload.php';
if(file_exists(APP_ROOT.'../.env.external')) {
	$dotEnv = new Dotenv\Dotenv(APP_ROOT.'../', '.env.external');
	$dotEnv->load();
}

define('YII_DEBUG', \App\Helpers\Env::get('YII_DEBUG', true));
define('YII_ENV', \App\Helpers\Env::get('YII_ENV', 'development'));

define('YII_ENV_PROD', YII_ENV === 'production');

define('YII_ENV_DEV', YII_ENV === 'development');

define('YII_ENV_TEST', YII_ENV === 'testing');

define('YII_ENV_STATING', YII_ENV === 'stating');


require APP_ROOT . 'vendor/yiisoft/yii2/Yii.php';
Yii::setAlias('@config', APP_ROOT . 'config/');
Yii::setAlias('@App', APP_ROOT . '/src');
$config = require APP_ROOT . 'config/web/web.php';

(new yii\web\Application($config))->run();
// @codingStandardsIgnoreEnd
