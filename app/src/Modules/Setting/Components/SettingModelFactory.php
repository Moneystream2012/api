<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Setting\Components;

use App\Components\BaseModelFactory;
use App\Modules\Setting\Models\{Setting, SettingGroup};

/**
 * Class SettingModelFactory
 * @package App\Modules\Setting\Components
 */
class SettingModelFactory extends BaseModelFactory
{
    public const SETTING = 'setting';
    public const SETTING_GROUP = 'settingGroup';

    /**
     * Method which populates @var $models
     */
    protected static function populateModels(): void
    {
        static::$models = [
            static::SETTING => Setting::class,
            static::SETTING_GROUP => SettingGroup::class,
        ];
    }

}