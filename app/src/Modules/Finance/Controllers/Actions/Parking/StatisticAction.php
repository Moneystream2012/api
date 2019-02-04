<?php
/**
 * @author Tarasenko Andrii
 * @date: 29.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use App\Modules\Finance\Models\FinanceParking;
use Danhunsaker\BC;
use \Yii;
use yii\rest\Action;

/**
 * Class UserParkingBalance
 * @package App\Modules\Finance\Controllers\Actions\Parking
 */
class StatisticAction extends Action
{
    public function run() {

        $items = $this->modelClass::find()
            ->whereStatus([FinanceParking::TYPE_ACTIVE, FinanceParking::TYPE_PENDING])
            ->with(['type'])
            ->asArray()
            ->all();

        $result = [];
        foreach ($items as $item) {

            if (empty($result[$item['type']['name']])) {
                $result[$item['type']['name']] = [
                    'name' => $item['type']['name'],
                    'period' => $item['type']['period'],
                    'balance' => BC::add(0, $item['amount'], Yii::$app->params['scale'])
                ];
            } else {
                $result[$item['type']['name']] = [
                    'name' => $item['type']['name'],
                    'period' => $item['type']['period'],
                    'balance' => BC::add($result[$item['type']['name']]['balance'], $item['amount'], Yii::$app->params['scale'])
                ];
            }

        }

        return array_values($result);
    }
}
