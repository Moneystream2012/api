<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 31.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use App\Modules\Finance\Models\AddressBalanceLogStatistic\ReserveStatistic;
use yii\helpers\ArrayHelper;

class FinanceAddressBalanceLog extends \App\Modules\Database\FinanceAddressBalanceLog
{
    public const TYPE_DIRECT = 'direct';
    public const TYPE_ROLLBACK = 'rollback';


    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = [
            [['transactionId'], 'string', 'max' => 64],
            [['status'], 'in', 'range' => $this->getStatusRange()],
            [['createdAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'addressBalanceId',
            'transactionId',
            'amount',
            'balance',
            'status',
            'createdAt',
        ];
    }

    public function getStatusRange(): array
    {
        return [
            self::TYPE_DIRECT,
            self::TYPE_ROLLBACK,
        ];
    }

    /**
     * @return array|null
     */
    public static function getReserveStatistic(): ?array
    {
        $model = new ReserveStatistic();
        return $model->getStatistic();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function dayStatisticByAddressId( int $id): array {
        return self::findBySql(
            '
SELECT 
DATE(`createdAt`) AS `name`,
`balance` AS `value`
FROM
  `minex_finance_address_balance_log` WHERE `createdAt` IN (
	SELECT 
	 MAX(`createdAt`) AS `createdAt`
	FROM
	  `minex_finance_address_balance_log` 
	WHERE `createdAt` >= DATE_ADD(CURDATE(), INTERVAL - 7 DAY) AND `addressBalanceId` = :addressBalanceId
	GROUP BY DATE(`createdAt`)
    )', ['addressBalanceId' => $id])->asArray()->all();
    }
}
