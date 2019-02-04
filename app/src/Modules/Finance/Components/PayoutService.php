<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 13.10.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Components;

use App\Helpers\NodeTransaction;
use App\Modules\Finance\Exceptions\PayoutServiceException;
use App\Modules\Finance\Models\FinanceTransaction;
use App\Modules\Finance\Models\FinanceTransactionLog;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class PayoutService
 * @package App\Modules\Finance\Components
 */
class PayoutService extends Object
{
    private const LOG_CATEGORY = 'payoutService';

    /**
     * @var string
     */
    public $addressForChange;

    /**
     * @var float
     */
    public $transactionFee = 0.00001;

    /**
     * @var NodeTransaction
     */
    private $nodeTransaction;

    public function init() {
        $this->nodeTransaction = new NodeTransaction();
        $this->nodeTransaction->fee = $this->transactionFee;
        $this->setAddressForChange();
    }

    /**
     * @param array $outputs
     * @param float $totalAmount
     *
     * @return array
     */
    public function addAddressForChangeToOutputsIfNeed(array $outputs, float $totalAmount): array
    {
        $outputAmount = array_sum($outputs);

        $change = $totalAmount - $outputAmount - $this->transactionFee;

        if ($change >= $this->transactionFee) {
            $outputs[ $this->addressForChange ] = (float)number_format($change, 8, '.', '');
        }

        return $outputs;
    }

    public function sendPayoutTransaction(array $payouts): ?string {
        $result = null;

        try {
            $totalAmount = array_sum($payouts);
            $inputs = $this->nodeTransaction->getUnspentInputs($totalAmount);

            while (empty($inputs)) {
                \Yii::warning('Not enough inputs for payout. sleep(30)', static::LOG_CATEGORY);
                sleep(30);
                $inputs = $this->nodeTransaction->getUnspentInputs($totalAmount);
            }

            //TODO: refactor
            $payouts = $this->addAddressForChangeToOutputsIfNeed($payouts, array_sum(array_map(function($item) { return $item['amount'];}, $inputs)));

            $data = $this->nodeTransaction->prepareTransaction($inputs, $payouts);

            if (!$data['complete']) {
                throw new PayoutServiceException('Transaction status are not complete!');
            }

            $result = $this->nodeTransaction->sendRawTransaction($data['hex']);

        } catch (\Throwable $exception) {
            \Yii::info($exception->getMessage());
        }

        return $result;
    }

    public function updateTransactionsWithLog(array $transactionIds, string $transactionHash): bool {
        $dbTransactions = $this->saveTransactionsToDb($transactionIds, $transactionHash);

        return $this->saveTransactionLogsToDb($dbTransactions);
    }

    public function saveTransactionsToDb(array $transactionsIds, string $transactionHash): array {

        /* @var FinanceTransaction $class */
        $class = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        $result = [];

        $transactions = $class::find()->where(['id' => $transactionsIds])->all();

        foreach ($transactions as $transaction) {

            $transaction->hash = $transactionHash;
            $transaction->status = $class::TYPE_PENDING;

            if (!$transaction->save()) {
                \Yii::error($transaction->getErrors(), self::LOG_CATEGORY);
                continue;
            }

            $result[$transaction->id] = [
                'transactionId' => $transaction->id,
                'status' => $transaction->status,
                'createdAt' => \Yii::$app->formatter->asDatetime(time(), $class::DB_DATE_TIME_FORMAT)
            ];
        }

        return $result;
    }

    public function saveBlankTransactionsToDb(array $transactions): array {

        /* @var FinanceTransaction $class */
        $class = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        $result = [];

        foreach ($transactions as $transaction) {

            /* @var FinanceTransaction $model */
            $model = new $class();

            $model->load($transaction, '');

            if (!$model->save()) {
                \Yii::error($model->getErrors(), self::LOG_CATEGORY);
                continue;
            }

            $result[] = $model->id;
        }

        return $result;
    }

    public function saveTransactionLogsToDb(array $dbTransactions): bool {

        $inputCount = count($dbTransactions);
        /* @var FinanceTransactionLog $class */
        $class = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION_LOG);

        $savedCount = \Yii::$app->db->createCommand()->batchInsert(
            $class::tableName(),
            ['transactionId', 'status', 'createdAt'],
            $dbTransactions
        )->execute();

        if ($inputCount !== $savedCount) {
            \Yii::warning('Not all logs saved. Input count: '.$inputCount. ', but saved count is: ' . $savedCount);
        }

        return $inputCount === $savedCount;
    }

    public function populateTransactionsWithHash(array $transactions, string $hash): array {
        return array_map(function ($transaction) use($hash) {
            $transaction['hash'] = $hash;
            return $transaction;

        }, $transactions);
    }

    public function saveBlankTransactions(array $dataForDbPayoutTransactions): array {
        $add = '00000000000000000000000000000';
        $transactions = $this->populateTransactionsWithHash($dataForDbPayoutTransactions, $add . 'blank0' . $add );

        return $this->saveBlankTransactionsToDb($transactions);
    }

    private function setAddressForChange(): void {
        $model = FinanceModelFactory::getClass(FinanceModelFactory::PAYOUT_SOURCE)::find()->asArray()->one();

        if (!empty($model)) {
            $this->addressForChange = $model['address'];
        }
    }
}