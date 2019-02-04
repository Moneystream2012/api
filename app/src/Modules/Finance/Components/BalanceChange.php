<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 16.10.17
 * Time: 15:14
 */
declare(strict_types=1);

namespace App\Modules\Finance\Components;

use App\Components\Math;
use App\Modules\Finance\Models\FinanceAddressBalance;
use yii\base\Component;
use Yii;
use yii\base\ErrorException;
use yii\db\Exception;
use yii\helpers\Console;

/**
 * Class BalanceChange
 * @package App\Modules\Finance\Components
 */
class BalanceChange extends Component
{

	/**
	 * @var
	 */
	protected $changes;

	/**
	 * @var array
	 */
	protected $logs = [];

    /**
     * @var ParkingService
     */
	private $parking;

	public $transactionsTime = null;

    const LOG_CATEGORY = 'BalanceChange';

    /**
     * Init component
     */
    public function init(): void {
        $this->setParkingService(new ParkingService());
    }

    /**
     * @param ParkingService $service
     */
    public function setParkingService(ParkingService $service): void {
        $this->parking = $service;
    }

    /**
     * @param array $changes
     * @throws \Exception
     */
	public function proceed(array $changes): void {
        $dbTransaction = Yii::$app->db->beginTransaction();

        try {
            $this->proceedBalanceChanges($changes);
            $this->saveLogs();
            $dbTransaction->commit();
        } catch (\Exception $e) {
            $dbTransaction->rollBack();
            throw $e;
        }
	}

    /**
     * @param array $balanceChanges
     */
	private function proceedBalanceChanges(array $balanceChanges): void {
        foreach ($balanceChanges as $itemBalanceChange) {
            $this->updateChange($itemBalanceChange);
        }
	}

    /**
     * @param array $balanceChanges
     * @throws ErrorException
     */
	private function updateChange(array $balanceChanges): void {
        // не записуємо баланс для coinbase
		if ($balanceChanges['address'] == FinanceAddressBalance::COIN_BASE_ADDRESS) {
            return;
		}

        Yii::trace('Balance value for ' . $balanceChanges['address'] . ' is ' . $balanceChanges['balance'], self::LOG_CATEGORY);

        $addressBalanceModel = $this->getBalanceAddressModelByAddress($balanceChanges['address']);
        $addressBalanceModel->lastSync = $balanceChanges['lastSync'];

        $oldBalance = $addressBalanceModel->balance;

        foreach ($balanceChanges['transactions'] as $transaction)
        {
            $addressBalanceModel->balance = Math::Add($addressBalanceModel->balance, $transaction['amount'], 8);


            if($addressBalanceModel->balance  < 0) {
                Yii::error('!ALERT! balance < 0', self::LOG_CATEGORY);
                Yii::error([$addressBalanceModel->attributes, $transaction], self::LOG_CATEGORY);
                throw new ErrorException('Balance < 0. TransactionHash:' . $transaction['transactionId']);
            }

            if (!$addressBalanceModel->save()) {
                Yii::error($addressBalanceModel->getErrors(), self::LOG_CATEGORY);
                throw new ErrorException('Error to save addressBalance.');
            }

            Yii::trace('AddressBalanceModel for ' . $addressBalanceModel->address . ' updated. Balance - ' . $addressBalanceModel->balance, self::LOG_CATEGORY);

            $this->logAddressBalance($addressBalanceModel, $transaction, $balanceChanges['status']);
        }

        if ($addressBalanceModel->balance < $oldBalance) {

            Yii::info('Balance become lower then was. Was: '. $oldBalance . ', become: ' . $addressBalanceModel->balance, self::LOG_CATEGORY);

            $change[$addressBalanceModel->address] = $addressBalanceModel->balance;
            $this->parking->proceedBalanceChange($change);
        }
	}

    /**
     * @param string $address
     * @return FinanceAddressBalance
     */
	private function getBalanceAddressModelByAddress(string $address): FinanceAddressBalance {
        $modelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);
        $addressBalanceModel = $modelClass::find()->where(['address' => $address])->one();

        if ($addressBalanceModel == null) {
            $addressBalanceModel = $this->createAddressBalanceModelByAddress($address);
        }

        Yii::trace('AddressBalanceModel for '. $address .' finded!. Balance - ' . $addressBalanceModel->balance, self::LOG_CATEGORY);
        return $addressBalanceModel;
	}

    /**
     * @param string $address
     * @return FinanceAddressBalance
     */
	private function createAddressBalanceModelByAddress(string $address): FinanceAddressBalance {
        Yii::trace('AddressBalanceModel for ' . $address . ' is absent. Creating', self::LOG_CATEGORY);

        $modelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);

        return new $modelClass([
            'address' => $address,
            'balance' => 0,
        ]);
	}

    /**
     * Saving logs
     */
	private function saveLogs(): void {
	    $total = count($this->logs);
        Yii::info('Saving logs:'.$total, self::LOG_CATEGORY);

        $modelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE_LOG);
        $countSaved = Yii::$app->db->createCommand()->batchInsert(
            $modelClass::tableName(),
            ['addressBalanceId', 'transactionId', 'amount', 'balance', 'status', 'createdAt'],
            $this->logs
        )->execute();
        if($countSaved !== $total) {
            throw new Exception('Error to save ADDRESS_BALANCE_LOG. Saved:' . $countSaved);
        }
	}

    /**
     * @param FinanceAddressBalance $addressBalanceModel
     * @param array $transaction
     * @param string $status
     */
	private function logAddressBalance(FinanceAddressBalance $addressBalanceModel, array $transaction, string $status): void {
        $this->logs[] = [
            $addressBalanceModel->id,
            $transaction['transactionId'],
            $transaction['amount'],
            $addressBalanceModel->balance,
            $status,
            $this->transactionsTime,
        ];
	}
}
