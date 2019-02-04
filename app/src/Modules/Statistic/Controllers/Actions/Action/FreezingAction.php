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
 * Class FreezingAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class FreezingAction extends Action
{
    public function run() {

        $finance = new FinanceResponse();

        $freezing = $finance->getFreezingAmount();

//        $freezing = \Yii::$app->amqpRPCClient->createRequest(
//    'App\Modules\Finance\Workers\FinanceRPC',
//    'getFreezingAmount',
//            [],
//            true
//        );

        return [
            'total' => (float) $freezing,
        ];
    }
}