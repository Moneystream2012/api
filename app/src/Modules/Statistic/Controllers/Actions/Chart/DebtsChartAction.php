<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 09.11.17
 * Time: 15:31
 */

namespace App\Modules\Statistic\Controllers\Actions\Chart;

use App\Modules\Finance\Components\FinanceModelFactory;
use yii\rest\Action;

/**
 * Class DebtsChartAction
 * @package App\Modules\Statistic\Controllers\Actions\Chart
 */
class DebtsChartAction extends Action
{
    /**
     * @return array
     */
    public function run()
    {
        /** @var \App\Modules\Finance\Models\FinanceParking $parkingClass */
        $parkingClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        return [
            'debts' => $parkingClass::getFinanceDebsStatistic()
        ];
    }
}
