<?php
define('APP_ROOT', dirname(__DIR__) . '/');

require_once APP_ROOT . 'vendor/autoload.php';

$kernel = AspectMock\Kernel::getInstance();
$kernel->init([
    'includePaths' => [
        APP_ROOT . 'src',
//        APP_ROOT . 'vendor/yiisoft/yii2/web'
    ],
    'cacheDir' => APP_ROOT . 'runtime/aspect/',

]);

defined('YII_DEBUG') or define('YII_DEBUG', false);

defined('YII_ENV') or define('YII_ENV', 'test');

/*defined('YII_TEST_ENTRY_URL') or define(
    'YII_TEST_ENTRY_URL',
    parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], 5)

);

defined('YII_TEST_ENTRY_FILE') or define('YII_TEST_ENTRY_FILE', APP_ROOT . '/web/index-test.php');*/



// Load additional files via kernel
$kernel->loadFile(APP_ROOT . 'vendor/yiisoft/yii2/Yii.php');
$kernel->loadFile(APP_ROOT . 'vendor/yiisoft/yii2/base/UnknownClassException.php');
$kernel->loadFile(APP_ROOT . 'vendor/yiisoft/yii2/base/ErrorException.php');

//define('YII_ENV', 'test');
//defined('YII_DEBUG') or define('YII_DEBUG', true);

Yii::setAlias('@config', APP_ROOT . 'config/');
Yii::setAlias('@tests', APP_ROOT . 'tests/');

\AspectMock\Test::double(\yii\helpers\Console::class, ['stdout' => 'true']);