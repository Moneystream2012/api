<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Setting;

/**
 * Class SettingModule
 * @package App\Modules\Setting
 */
class SettingModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'App\Modules\Setting\Controllers';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }
}
