<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 03.11.17
 * Time: 18:06
 */

namespace App\Modules\Finance\Models\ParkingStatistic;


use App\Modules\Finance\Models\FinanceParkingStatisticAbstract;

/**
 * Class FinanceUserStatistic
 * @package App\Modules\Finance\Models\ParkingStatistic
 */
class FinanceUserStatistic extends FinanceParkingStatisticAbstract
{
    /**
     * @param int $id
     * @return array
     */
    protected function getParkingByType(int $id): array
    {
        return self::find()->select(['count(distinct userId) as amountResult', 'createdAt'])->byType($id)->activeParking()->orderBy(['id' => SORT_DESC])->groupByDays()->all();
    }

    /**
     * @return array
     */
    protected function getTotalParking(): array
    {
        return self::find()->select(['count(distinct userId) as amountResult', 'createdAt'])->activeParking()->orderBy(['id' => SORT_DESC])->groupByDays()->all();
    }
}
