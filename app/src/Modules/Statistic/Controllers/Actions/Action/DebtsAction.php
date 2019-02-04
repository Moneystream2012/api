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
 * Class DebtsAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class DebtsAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run(): array
    {
        $finance = new FinanceResponse();

        return $finance->getDebts();

//        return \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\Finance\Workers\FinanceRPC',
//            'getDebts',
//            [],
//            true
//        );
    }
}