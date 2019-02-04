<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support;

/**
 * Class SupportModule
 * @package App\Modules\Support
 */
class SupportModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'App\Modules\Support\Controllers';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }
}
