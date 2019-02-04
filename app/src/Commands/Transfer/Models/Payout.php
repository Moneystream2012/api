<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.10.17
 * Time: 19:58
 */

namespace App\Commands\Transfer\Models;


use App\Commands\Transfer\Exception\TransferException;
use App\Modules\Explorer\Components\ExplorerModelFactory;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceTransaction;
use Yii;
use yii\helpers\Console;
use yii\helpers\Json;

class Payout extends BaseModel
{
    const TRANSACTION_STATUS = 'completed';

    /**
     *
     */
    public function savePayoutData(): void
    {
        $data = $this->getPayoutData();
        $count = count($data) - 1;

        Console::startProgress(0, $count, __FUNCTION__);
        foreach ($data as $i => $item) {
            $this->deleteDuplicateTransactions($item);
            $this->savePayout($item);
            Console::updateProgress($i, $count, __FUNCTION__);
        }
        Console::endProgress();
    }

    /**
     * @param array $item
     * @throws TransferException
     */
    private function savePayout(array $item): void
    {
        $transactionClass = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);
        /** @var FinanceTransaction $transactionModel */
        $transactionModel = new $transactionClass;
        $transactionModel->detachBehavior('timestamp');

        $transactionModel->hash = $item['transaction_id'];
        $transactionModel->parkingId = $this->getParkingId((int)$item['parking_id']);
        $transactionModel->amount = $item['amount'];
        $transactionModel->fee = $this->getFee($item['transaction_id']);
        $transactionModel->status = self::TRANSACTION_STATUS;
        $transactionModel->createdAt = Yii::$app->formatter->asDatetime($item['created'], \App\Components\BaseModel::DB_DATE_TIME_FORMAT);
        $transactionModel->updatedAt = Yii::$app->formatter->asDatetime($item['created'], \App\Components\BaseModel::DB_DATE_TIME_FORMAT);

        if (!$transactionModel->save()) {
            Yii::error($transactionModel->getErrors());
            throw new TransferException('Cant save payouts#'.Json::encode($transactionModel->getErrors()));
        }

        $this->savePayoutLog($transactionModel);

        //Yii::info('Transaction item saved - '.$transactionModel->id);
    }

    /**
     * @param array $item
     */
    private function deleteDuplicateTransactions(array $item): void
    {
        $transactionClass = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);
        $transactionModel = $transactionClass::find()->where(['hash' => $item['transaction_id']])->all();

        foreach ($transactionModel as $transactionModelItem) {
            $this->deleteDuplicateTransactionLog($transactionModelItem->id);
            Yii::info('Delete duplicate transaction ' . $transactionModelItem->hash);
            $transactionModelItem->delete();
        }
    }


    /**
     * @param int $id
     */
    private function deleteDuplicateTransactionLog(int $id): void
    {
        $transactionLogClass = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION_LOG);
        $transactionLogModel = $transactionLogClass::find()->where(['transactionId' => $id])->all();

        foreach ($transactionLogModel as $transactionLogModelItem) {
            Yii::info('Delete duplicate transaction log ' . $transactionLogModelItem->transactionId);
            $transactionLogModelItem->delete();
        }
    }

    /**
     * @param FinanceTransaction $transactionModel
     * @throws TransferException
     */
    private function savePayoutLog(FinanceTransaction $transactionModel): void
    {
        $transactionLogClass = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION_LOG);
        $transactionLogModel = new $transactionLogClass;
        $transactionLogModel->detachBehavior('timestamp');

        $transactionLogModel->transactionId = $transactionModel->id;
        $transactionLogModel->status = self::TRANSACTION_STATUS;
        $transactionLogModel->createdAt = $transactionModel->createdAt;

        if (!$transactionLogModel->save()) {
            Yii::error($transactionLogModel->getErrors());
            throw new TransferException('Cant save payout log');
        }

        //Yii::info('Transaction log saved - '.$transactionLogModel->id);
    }

    /**
     * @param string $transactionId
     * @return null|string
     */
    private function getFee(string $transactionId): ?string
    {
        $transactionClass = ExplorerModelFactory::getClass(ExplorerModelFactory::TRANSACTION);
        $transactionModel = $transactionClass::find()->where(['hash' => $transactionId])->one();

        if (!is_null($transactionModel)) {
            return $transactionModel->fee;
        }

        return null;
    }

    /**
     * @param int $id
     * @return int|null
     */
    private function getParkingId(int $id): ?int
    {
        return ParkingProxy::getInstance()->getId($id);
    }

    /**
     * @return array
     */
    private function getPayoutData(): array
    {
        $data = $this->getFile('payout.cvs');
        return $this->transformData($data, [
            'id',
            'parking_id',
            'transaction_id',
            'user_id',
            'amount',
            'created'
        ]);
    }
}
