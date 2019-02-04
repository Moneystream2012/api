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

class SubscriberAndGroup extends \App\Modules\Database\SubscriberAndGroup
{

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['subscriberId', 'groupId'], 'required'],
            [['subscriberId', 'groupId'], 'integer'],
            [['subscriberId'], 'exist', 'skipOnError' => true, 'targetClass' => SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER), 'targetAttribute' => ['subscriberId' => 'id']],
            [['groupId'], 'exist', 'skipOnError' => true, 'targetClass' => SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER_GROUP), 'targetAttribute' => ['groupId' => 'id']],
            [['subscriberId', 'groupId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array {
	    return [
		    'id',
		    'subscriberId',
		    'groupId',
	    ];
    }
}
