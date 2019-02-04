<?php
/**
 * @author Tarasenko Andrii
 * @date: 13.10.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Components;

use App\Components\Math;
use App\Modules\Finance\Exceptions\ParkingServiceException;
use App\Modules\Finance\Models\FinanceParking;
use PHPUnit\Exception;
use Yii;
use yii\base\Object;
use yii\db\ActiveRecord;
use yii\helpers\Console;

/**
 * Class ParkingService
 * @package App\Modules\Finance\Components
 */
class ParkingService extends Object
{
    public const LOG_CATEGORY = 'parkingService';

    /**
     * @var FinanceParking
     */
    private $model;

    /**
     * @var
     */
    private $scale;

    /**
     * Init service
     */
    public function init(): void {
        $this->setParkingModel(FinanceModelFactory::create(FinanceModelFactory::PARKING));
        $this->scale = Yii::$app->params['scale'];
    }

    /**
     * @param $model
     */
    public function setParkingModel($model): void {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getExpiredParkings(int $max = 0): array {
        return $this->model->findExpiredParkings($max);
    }

    /**
     * @param array $parkings
     * @return array
     */
    public function getUserAddresses(array $parkings): array {
        return $this->model->getUserAddresses($parkings);
    }

    /**
     * @param array $parking
     * @return float
     */
    public function getPayoutAmount(array $parking): float {
        $result = $parking['amount'] * $parking['rate']/100;

        return (float) number_format($result, 8);
    }

    /**
     * @param array $parkings
     * @return float
     */
    public function getSumOfPayoutAmounts(array $parkings): float {
        $result = 0;

        foreach ($parkings as $parking) {
            $result += $this->getPayoutAmount($parking);
        }

        return $result;
    }

    /**
     * @param array $parkings
     * @throws ParkingServiceException
     */
    public function completeParkings(array $parkings): void {
        $ids = array_map(function ($parking) { return $parking['id']; }, $parkings);
        if (!$this->model->completeParkings($ids)) {
            throw new ParkingServiceException('Not all parkings updated');
        }
    }

    public function proceedBalanceChange(array $userBalances): void {

        $this->console('Start processing balance change for parkings...' . "\n");

        Yii::info($userBalances, self::LOG_CATEGORY);

        $parkingsForCancel = $this->getParkingsForCancel($userBalances);

        if (!empty($parkingsForCancel)) {
            $this->console('Parkings for cancel');

            Yii::info($parkingsForCancel, self::LOG_CATEGORY);

            $this->cancelParkings($parkingsForCancel);
        }
    }

    /**
     * @param array $userBalances
     * @return array
     */
    public function getParkingsForCancel(array $userBalances): array {

        $this->console('Search for parkings to cancel...');

        $result = [];

        $addresses = array_keys($userBalances);

        $parkings = $this->model->getParkingsByAddresses($addresses);

        if (!empty($parkings)) {
            $this->console('Find parkings for cancel');
            Yii::info($parkings, self::LOG_CATEGORY);

        }

        foreach ($userBalances as $address => $amount) {
            if (!empty($parkings[$address])) {
                $result = array_merge($result, $this->getParkingsNotInSetAmount((float)$amount, $parkings[$address]));
            }
        }

        return $result;
    }

    public function getParkingsNotInSetAmount(float $amount, array $parkings): array {

        $parkingAmount = 0;

        foreach ($parkings as $parking) {
            $parkingAmount = (float)Math::Add($parkingAmount, $parking['amount'], $this->scale);
        }

        Yii::info($amount, self::LOG_CATEGORY);
        Yii::info($parkingAmount, self::LOG_CATEGORY);
        Yii::info($parkings, self::LOG_CATEGORY);

        $parkingsToCancel = [];
        while ($parkingAmount > $amount && !empty($parkings)) {
            $parking = array_shift($parkings);

            Yii::info($parking, self::LOG_CATEGORY);

            $parkingAmount = Math::Sub($parkingAmount, $parking['amount'], $this->scale);
            $parkingsToCancel[] = $parking;
        }

        return $parkingsToCancel;
    }

    /**
     * @param array $parkings
     * @throws ParkingServiceException
     */
    public function cancelParkings(array $parkings): void {
        $ids = array_map(function ($parking) { return $parking['id']; }, $parkings);
        if (!$this->model->cancelParkings($ids)) {
            throw new ParkingServiceException('Not all parkings canceled');
        }
    }

    private function console(string $message): void {
        if (YII_ENV_DEV) {
            Console::stdout($message . "\n");
        }
    }
}
