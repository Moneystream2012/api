<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * Date: 20.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceResponse;
use yii\rest\Action;

/**
 * Class HotReserveAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class HotReserveAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run(): array
    {
        $finance = new FinanceResponse();

        $total = $finance->getHotReserve();

//        $balance = \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\Finance\Workers\FinanceRPC',
//            'getHotReserve',
//            [],
//            true
//        );

        return ['total' => $total];
    }
}