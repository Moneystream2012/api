<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.11.17
 * Time: 19:14
 */

namespace App\Modules\Statistic\Models;

use \DateTime;
use \DateInterval;
use \DatePeriod;


/**
 * Class OnHands
 * @package App\Modules\Statistic\Models
 */
class OnHands
{
    /**
     * @param array $totalSupplyData
     * @param array $reserveStatisticData
     * @return array
     */
    public function getStatistic(array $totalSupplyData, array $reserveStatisticData): array
    {
        $result = [];

        $datePeriod = $this->getDatePeriod();

        foreach ($datePeriod as $dateItem) {

            $totalSupplyItem = $this->getItemValueByDate($totalSupplyData, $dateItem->format('Y-m-d'));
            $reservedStatisticItem = $this->getItemValueByDate($reserveStatisticData, $dateItem->format('Y-m-d'));

            $result[] = [
                'name' => $dateItem->format('Y-m-d'),
                'value' => $totalSupplyItem - $reservedStatisticItem - 1000000,
            ];
        }

        return $result;
    }

    /**
     * @return DatePeriod
     */
    private function getDatePeriod(): DatePeriod
    {
        $begin = new DateTime();
        $begin->sub(new DateInterval('P7D'));
        $end = new DateTime();
        $end->add(new DateInterval('P1D'));

        return new DatePeriod($begin, new DateInterval('P1D'), $end);
    }

    /**
     * @param array $data
     * @param string $date
     * @return float
     */
    private function getItemValueByDate(array $data, string $date): float
    {
        foreach ($data as $item) {
            if ($item['name'] == $date) {
                return $item['value'];
            }
        }

        return 0.0;
    }

}
