<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Workers;

use App\Components\Amqp\AmqpRPCServerConsumers;
use App\Modules\Subscribe\Components\SubscribeModelFactory;

/**
 * Class SubscribeRPC
 * @package App\Modules\Subscribe\Workers
 */
class SubscribeRPC extends AmqpRPCServerConsumers
{
    public function getTotalSubscribers(): int {

        $modelClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER);

        $total = (int) $modelClass::find()->count();

        return $total;
    }
}