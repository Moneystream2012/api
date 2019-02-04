<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Subscribe\Components\SubscribeResponse;
use yii\rest\Action;

/**
 * Class SubscriberCountAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class SubscriberCountAction extends Action
{
    public function run() {

        $subscribe = new SubscribeResponse();

        $total = $subscribe->getTotalSubscribers();

//        $total = \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\Subscribe\Workers\SubscribeRPC',
//            'getTotalSubscribers',
//            [],
//            true
//        );

        return [
            'total' => $total
        ];
    }
}