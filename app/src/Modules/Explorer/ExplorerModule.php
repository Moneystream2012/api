<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 08.08.17
 */
declare(strict_types=1);

namespace App\Modules\Explorer;


/**
 * Class ExplorerModule
 * @package App\Modules\Explorer
 */
class ExplorerModule extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = __NAMESPACE__ . '\Controllers';

}