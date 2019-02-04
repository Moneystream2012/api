<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceResponse;
use yii\rest\Action;

/**
 * Class PayoutsAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class PayoutsAction extends Action
{
    public function run() {

        $finance = new FinanceResponse();

        $result = $finance->getTotalPayouts();

        return $result;

//        return \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\Finance\Workers\FinanceRPC',
//            'getTotalPayouts',
//            [],
//            true
//        );
    }
}