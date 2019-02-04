<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 22.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceModelFactory;
use yii\base\UserException;
use yii\rest\Action;

/**
 * Class ColdWalletAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class ColdWalletAction extends Action
{
    public function run() {
        $row = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE)
            ::find()
            ->isColdWalletAddress()
            ->asArray()
            ->one();

        if(!$row) {
            throw new UserException('Cold address not found in balance table.');
        }
        return ['total' => $row['balance']];
    }
}