<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.10.17
 * Time: 18:26
 */

namespace App\Commands\Transfer\Models;


use App\Commands\Transfer\Exception\TransferException;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceParking;
use Yii;
use yii\helpers\Console;

class Parking extends BaseModel
{
    private $parkingTypeData = [];

    private static $types = [
        0 => FinanceParking::TYPE_CANCELED,
        1 => FinanceParking::TYPE_ACTIVE,
        2 => FinanceParking::TYPE_COMPLETED,
    ];

    public function __construct()
    {
        $data = $this->getParkingTypeData();
        $this->storeParkingTypeData($data);
    }

    /**
     *
     */
    public function saveParkingData(): void
    {
        $data = $this->getParkingData();
        $count = count($data) - 1;
        Console::startProgress(0, $count, __FUNCTION__);
        foreach ($data as $i => $item) {
            $this->saveParking($item);
            //Yii::info('Parking item saved - '.$item['id']);
            Console::updateProgress($i, $count, __FUNCTION__);
        }
        Console::endProgress();
    }

    /**
     * @param array $item
     * @throws TransferException
     */
    public function saveParking(array $item): void
    {
        $parkingModel = new \App\Commands\Transfer\Models\FinanceParking();
        $parkingModel->detachBehavior('timestamp');
        $parkingModel->detachBehavior('blameable');

        $parkingModel->userId = $this->getUserId((int)$item['user_id']);
        $parkingModel->typeId = $this->getTypeId((int)$item['type_id']);
        $parkingModel->amount = $item['amount'];

        $parkingModel->rate = $item['rate'];
        $parkingModel->returnedAmount = $item['return_amount'];
        $parkingModel->endDate = Yii::$app->formatter->asDatetime($item['expired'], \App\Components\BaseModel::DB_DATE_TIME_FORMAT);

        $parkingModel->createdAt = Yii::$app->formatter->asDatetime($item['created'], \App\Components\BaseModel::DB_DATE_TIME_FORMAT);
        $parkingModel->status = self::getStatus((int)$item['status']);

        if (!$parkingModel->save()) {
            Yii::error($parkingModel->getErrors());
            throw new TransferException('Cant save parking');
        }

        ParkingProxy::getInstance()->saveId((int)$item['id'], $parkingModel->id);
        $this->saveParkingLog($parkingModel);
    }

    /**
     * @param int $id
     * @return int|null
     */
    private function getUserId(int $id)
    {
        return UserProxy::getInstance()->getId($id);
    }

    /**
     * @param FinanceParking $item
     * @throws TransferException
     */
    private function saveParkingLog(FinanceParking $item): void
    {
        $parkingLogClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_LOG);
        $parkingLogModel = new $parkingLogClass;
        $parkingLogModel->detachBehavior('timestamp');

        $parkingLogModel->parkingId = $item->id;
        $parkingLogModel->status = $item->status;
        $parkingLogModel->createdAt = $item->createdAt;

        if (!$parkingLogModel->save()) {
            Yii::error($parkingLogModel->getErrors());
            throw new TransferException('Cant save parking log');
        }
    }


    /**
     * @return array
     */
    public function getParkingData(): array
    {
        $data = $this->getFile('parking.cvs');
        return $this->transformData($data, [
            'id',
            'user_id',
            'type_id',
            'rate',
            'amount',
            'return_amount',
            'info',
            'status',
            'created',
            'expired',
            'device',
            'payout_prepared',
        ]);
    }


    /**
     * @param int $status
     * @return null|string
     */
    private static function getStatus(int $status): ?string
    {
        if (isset(self::$types[$status])) {
            return self::$types[$status];
        }

        return null;
    }


    /**
     * @return array
     */
    private function getParkingTypeData(): array
    {
        $data = $this->getFile('parking_types.cvs');
        return $this->transformData($data, [
            'id',
            'rate',
            'title',
            'period',
            'created',
        ]);
    }

    /**
     * @param array $data
     */
    private function storeParkingTypeData(array $data): void
    {
        foreach ($data as $item) {
            $this->parkingTypeData[$item['id']] = $item;
        }
    }

    /**
     * @param int $id
     * @return array|null
     */
    private function getParkingTypeById(int $id): ?array
    {
        if (isset($this->parkingTypeData[$id])) {
            return $this->parkingTypeData[$id];
        }

        return null;
    }

    /**
     * @param int $id
     * @return null|string
     */
    private function getParkingNameById(int $id): ?string
    {
        if (isset($this->parkingTypeData[$id])) {
            return $this->parkingTypeData[$id]['title'];
        }

        return null;
    }

    /**
     * @param int $typeId
     * @return int
     * @throws TransferException
     */
    private function getTypeId(int $typeId): int
    {
        $parkingName = $this->getParkingNameById($typeId);

        // todo: не жухати базу так сильно
        $parkingTypeClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);
        $parkingTypeModel = $parkingTypeClass::find()->where(['lower(name)' => $parkingName])->one();

        if (is_null($parkingTypeModel)) {
            $parking = $this->getParkingTypeById($typeId);

            $model = new $parkingTypeClass;
            $model->name = $parking['title'];
            $model->rate = $parking['rate'];
            $model->period = $this->transformParkingPeriod((int)$parking['period']);

            if (!$model->save()) {
                Yii::error($model->getErrors());
                throw new TransferException('Cant save parking type');
            }

            return $model->id;

        }

        return $parkingTypeModel->id;
    }

    /**
     * @param int $period
     * @return int
     */
    public function transformParkingPeriod(int $period): int
    {
        return $period * 86400;
    }
}
