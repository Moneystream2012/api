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
 * Class OnHandAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class OnHandAction extends Action
{
    public function run() {

        $finance = new FinanceResponse();

        $total = $finance->getOnHandAmount();

//        $onHand = \Yii::$app->amqpRPCClient->createRequest(
//    'App\Modules\Finance\Workers\FinanceRPC',
//    'getOnHandAmount',
//            [],
//            true
//        );

        return [
            'total' => $total,
        ];
    }
}