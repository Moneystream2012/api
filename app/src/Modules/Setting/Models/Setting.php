<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Setting\Models;

use App\{
    Modules\Setting\Components\SettingModelFactory
};

/**
 * Class Setting
 * @package App\Modules\Setting\Model
 */
class Setting extends \App\Modules\Database\Setting
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['groupId', 'name', 'shortName', 'value', 'default'], 'required'],
            [['groupId'], 'integer'],
            [['name'], 'string', 'min' => 3, 'max' => 100],
            [['shortName'], 'string', 'min' => 3, 'max' => 40],
            [['value'], 'string', 'max' => 255],
            [['default'], 'string', 'max' => 255],
            [['createdAt'],'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['groupId'], 'exist', 'skipOnError' => true, 'targetClass' => SettingModelFactory::getClass(SettingModelFactory::SETTING_GROUP), 'targetAttribute' => ['groupId' => 'id']],
            [['groupId', 'name', 'shortName', 'value', 'default'], 'safe'],
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
            'value',
            'default',
            'createdAt',
            'groupId',
        ];
    }

    /**
     * @inheritdoc
     */
}
