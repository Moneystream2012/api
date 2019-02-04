<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 30.11.17
 * Time: 13:39
 */

namespace App\Commands;


use App\Commands\Transfer\Models\Parking;
use App\Commands\Transfer\Models\UserData;
use App\Commands\Transfer\Models\UserProxy;
use App\Modules\User\Components\UserModelFactory;
use yii\console\Controller;
use yii\db\ActiveRecord;

/**
 * Class FixTransferController
 * @package App\Commands
 */
class FixTransferController extends Controller
{
    /**
     * @var array
     */
    private static $addresses = [
        'XCfwacz1bpN9TDVqg7hnjRTKoTEtj4x7D3',
        'XBMURchZrGRhMb4sjnxLQoSajzY9kmm45N',
        'XU7tbwAT7KwNsHP7j8icNNW3pq8HDrkJyj',
        'XFP1xsij78YSzgDERZw8wCuDfQcPMkuABg',
        'XPUbTovNwW6jpHssShQiCMtG6R6zK2B2T8',
        'XDnfCxt7nnhREWYcMLdd3r32LvTRHnqwZc',
        'XTWoTuNs4ueHdvKRJQwa8qDURR4Rq7hUjF',
        'XMNr5kfmGvjNE57LMbPcpxdCXRXUmGujB7',
        'XFLctQAHheSzejp5gDaeZAkkydu2A9evdJ',
        'XPwJJugCKWWBQL1P8RoY8ELY8AzSiNGXmE',
        'XFExnZdh4wGYNGYsD8p54q584w23H8VDmr',
        'XUzQTC5r5uda5qdgyZu4xd3YLAs1UABYXn',
        'XLvv9MThMAqsp66yC8b9g1NpSNyPKDKnKA',
    ];

    /**
     * @throws \Exception
     */
    public function actionIndex(): void
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $parkings = [];

            $userModelClass = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS);
            $userModels = $userModelClass::find()->where(['address' => self::$addresses])->all();

            foreach ($userModels as $userModel) {
                $parkings = array_merge($parkings, $this->getParkingByUser($userModel));
                UserProxy::getInstance()->saveId($userModel->userId, $userModel->userId);
            }

            $parkingModel = new Parking();
            foreach ($parkings as $parking) {
                $parkingModel->saveParking($parking);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @param ActiveRecord $user
     * @return array
     */
    private function getParkingByUser(ActiveRecord $user): array
    {
        $userIds = $this->findUserIdsByAddress($user->address);
        return $this->findParkingsByUserIds($userIds, $user->userId);
    }

    /**
     * @param $address
     * @return array
     */
    private function findUserIdsByAddress($address): array
    {
        $ids = [];

        $userDataModel = new UserData();
        $userData = $userDataModel->getUserData();

        $users = array_filter($userData, function ($data) use($address) {
            return $data['address'] == $address;
        });

        foreach ($users as $user) {
            $ids[] = $user['id'];
        }

        return $ids;
    }

    /**
     * @param $ids
     * @param $id
     * @return array
     */
    private function findParkingsByUserIds($ids, $id): array
    {
        $parking = new Parking();
        $parkingData = $parking->getParkingData();

        $parkingResult = array_filter($parkingData, function ($data) use($ids) {
            return in_array($data['user_id'], $ids);
        });


        foreach ($parkingResult as $i => $parking) {
            $parkingResult[$i]['user_id'] = $id;
        }

        return $parkingResult;
    }
}
