<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 22.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Chart;

use App\Components\GlobalConstants;
use App\Modules\Finance\Components\FinanceModelFactory;
use yii\rest\Action;

/**
 * Class ColdWalletAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class ColdWalletAction extends Action implements GlobalConstants
{
    public function run() {
        $balance = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE)::findOne(['address' => self::COLD_WALLET_ADDRESS]);

        $model = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE_LOG);


        /** @var \App\Modules\Finance\Models\FinanceAddressBalanceLog $model */
        $result = $model::dayStatisticByAddressId($balance->id);

        return [
            'name' => 'Cold wallet',
            'series' => $result
        ];
    }
}