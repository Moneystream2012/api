<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 24.10.17
 * Time: 21:04
 */

namespace App\Modules\Statistic\Controllers\Actions\Chart;


use App\Modules\Explorer\Components\ExplorerModelFactory;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Statistic\Models\OnHands;
use yii\rest\Action;

/**
 * Class TotalSupplyChartAction
 * @package App\Modules\Statistic\Controllers\Actions\Chart
 */
class TotalSupplyChartAction extends Action
{
    /**
     * @return array
     */
    public function run()
    {
        $blockModelClass = ExplorerModelFactory::getClass(ExplorerModelFactory::BLOCK);
        $financeModelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE_LOG);

        $totalSupplyData = $blockModelClass::getTotalSupplyData();
        $reserveStatisticData = $financeModelClass::getReserveStatistic();

        $onHands = new OnHands();
        $onHandsData = $onHands->getStatistic($totalSupplyData, $reserveStatisticData);

        return [
            'TotalSupply' => [
                'name' => 'TotalSupply',
                'series' => $totalSupplyData
            ],
            'Reserve' => [
                'name' => 'Reserve',
                'series' => $reserveStatisticData
            ],
            'OnHands' => [
                'name' => 'On hands',
                'series' => $onHandsData
            ]
        ];
    }
}
