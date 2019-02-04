<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 31.10.17
 * Time: 19:58
 */

namespace App\Modules\Finance\Models;


use App\Modules\Finance\Components\FinanceModelFactory;

/**
 * Class FinanceParkingStatisticAbstract
 * @package App\Modules\Finance\Models
 */
abstract class FinanceParkingStatisticAbstract extends FinanceParking
{
    public $amountResult;

    /**
     * @return array
     */
    public function getStatistic(): array
    {
        $result = [];

        $parkingTypes = $this->getParkingTypes();

        foreach ($parkingTypes as $i => $type) {

            $result[$type->id]['name'] = $type->name;

            $parkingModels = $this->getParkingByType($type->id);

            foreach ($parkingModels as $parkingModel) {
                $result[$type->id]['series'][] = [
                    'name' => $parkingModel->getFormattedCreatedAt(),
                    'value' => $parkingModel->amountResult,
                ];
            }
        }

        $totalParkingCountModels = $this->getTotalParking();

        $result['total']['name'] = 'Total parking';

        foreach ($totalParkingCountModels as $i => $totalParkingCountModel) {
            $result['total']['series'][] = [
                'name' => $totalParkingCountModel->getFormattedCreatedAt(),
                'value' => $totalParkingCountModel->amountResult
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getParkingTypes(): array
    {
        $parkingTypesClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);
        return $parkingTypesClass::find()->all();
    }

    /**
     * @return string
     */
    public function getFormattedCreatedAt(): string
    {
        return date('Y-m-d', strtotime($this->createdAt));
    }

    /**
     * @param int $id
     * @return array
     */
    abstract protected function getParkingByType(int $id): array;

    /**
     * @return array
     */
    abstract protected function getTotalParking(): array;
}
