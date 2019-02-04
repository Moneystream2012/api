<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Setting\Models;

/**
 * Class SettingGroup
 * @package App\Modules\Setting\Model
 */
class SettingGroup extends \App\Modules\Database\SettingGroup
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name', 'shortName'], 'unique'],
            [['name'], 'string', 'min' => 3, 'max' => 100],
            [['shortName'], 'string', 'min' => 3, 'max' => 20],
            [['name','shortName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'name',
            'shortName',
        ];
    }
}
