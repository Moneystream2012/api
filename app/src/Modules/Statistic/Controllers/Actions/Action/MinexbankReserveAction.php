<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceResponse;
use yii\rest\Action;

/**
 * Class MinexbankReserveAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class MinexbankReserveAction extends Action
{
    public function run() {

        $finance = new FinanceResponse();
        $reserve = $finance->getMinexbankReserve();

//        $reserve = \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\Finance\Workers\FinanceRPC',
//            'getMinexbankReserve',
//            [],
//            true
//        );

        return [
            'total' => $reserve,
        ];
    }
}