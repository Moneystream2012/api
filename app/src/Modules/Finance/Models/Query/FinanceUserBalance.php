<?php
/**
 * @author Tarasenko Andrii
 * @date: 29.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models\Query;

use App\Components\GlobalConstants;
use App\Traits\ActiveQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class FinanceUserBalance
 * @package App\Modules\Finance\Model\Query
 */
class FinanceUserBalance extends ActiveQuery implements GlobalConstants
{
    use ActiveQueryTrait;

    /**
     * @return $this
     */
    public function isColdWalletAddress() {
        $this->andWhere(['address' => self::COLD_WALLET_ADDRESS]);

        return $this;
    }
}
