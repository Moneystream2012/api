<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Models;

use App\{
	Modules\Subscribe\Components\SubscribeModelFactory
};

class Subscriber extends \App\Modules\Database\Subscriber
{


    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['email',], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['sourceId'], 'default', 'value' => 1],
            [['createdAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['sourceId'], 'exist', 'skipOnError' => true, 'targetClass' => SubscribeModelFactory::getClass(SubscribeModelFactory::SOURCE), 'targetAttribute' => ['sourceId' => 'id']],
            [['sourceId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'email',
            'sourceId',
            'createdAt',
        ];
    }
}
