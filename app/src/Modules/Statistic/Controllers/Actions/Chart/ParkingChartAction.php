<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 31.10.17
 * Time: 19:47
 */

namespace App\Modules\Statistic\Controllers\Actions\Chart;

use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Components\FinanceResponse;
use yii\db\Expression;
use yii\rest\Action;

/**
 * Class ParkingChartAction
 * @package App\Modules\Statistic\Controllers\Actions\Chart
 */
class ParkingChartAction extends Action
{
    /**
     * @return array
     */
    public function run(): array
    {
        /** @var \App\Modules\Finance\Models\FinanceParking $parkingClass */
        $parkingClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        return [
            'amounts' => $parkingClass::getFinanceSumStatistic(),
            'counts' => $parkingClass::getFinanceCountStatistic(),
            'users' => $parkingClass::getFinanceUserStatistic(),
        ];
    }


}
