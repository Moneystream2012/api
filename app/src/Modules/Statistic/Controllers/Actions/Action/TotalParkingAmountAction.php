<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 22.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceResponse;
use yii\rest\Action;

/**
 * Class TotalParkingAmountAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class TotalParkingAmountAction extends Action
{
    public function run() {

        $finance = new FinanceResponse();

        return $finance->getTotalParkingAmount();
//        return \Yii::$app->amqpRPCClient->createRequest(
//    'App\Modules\Finance\Workers\FinanceRPC',
//    'getTotalParkingAmount',
//            [],
//            true
//        );
    }
}