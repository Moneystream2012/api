<?php
/**
 * @author Tarasenko Andrii
 * @date: 22.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceResponse;
use yii\rest\Action;

/**
 * Class ParkingAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class ParkingAction extends Action
{
    public function run() {

        $finance = new FinanceResponse();

        $result = $finance->getTotalParkings();


        return $result;
//        return \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\Finance\Workers\FinanceRPC',
//            'getTotalParkings',
//            [],
//            true
//        );
    }
}
