<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 09.11.17
 * Time: 15:39
 */

namespace App\Modules\Finance\Models\ParkingStatistic;

use App\Modules\Finance\Models\FinanceParkingStatisticAbstract;

/**
 * Class FinanceDebtsStatistic
 * @package App\Modules\Finance\Models\ParkingStatistic
 */
class FinanceDebtsStatistic extends FinanceParkingStatisticAbstract
{
    const PERIOD = 7;

    /**
     * @param int $id
     * @return array
     */
    public function getParkingByType(int $id): array
    {
        return self::find()->select(['sum(amount) as amountResult', 'createdAt'])
            ->byType($id)
            ->activeParking()
            ->andWhere(['between', 'date(endDate)', $this->getStartDate(), $this->getEndDate()])
            ->orderBy(['id' => SORT_DESC])
            ->groupByDays()
            ->all();
    }

    /**
     * @return array
     */
    public function getTotalParking(): array
    {
        return self::find()->select(['sum(amount) as amountResult', 'createdAt'])
            ->activeParking()
            ->andWhere(['between', 'date(endDate)', $this->getStartDate(), $this->getEndDate()])
            ->orderBy(['id' => SORT_DESC])
            ->groupByDays()
            ->all();
    }

    /**
     * @return string
     */
    private function getStartDate(): string
    {
        $startDate = new \DateTime();
        return $startDate->format('Y-m-d');
    }

    /**
     * @return string
     */
    private function getEndDate(): string
    {
        $endDate = new \DateTime();
        $endDate->add(new \DateInterval('P' . self::PERIOD .  'D'));
        return $endDate->format('Y-m-d');
    }
}
