<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.10.17
 * Time: 18:13
 */

namespace App\Commands\Transfer\Models;

use App\Commands\Transfer\Exception\TransferException;
use App\Modules\Database\AuthAssignment;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Subscribe\Components\SubscribeModelFactory;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Models\User;
use Yii;
use yii\helpers\Console;
use yii\helpers\Json;

class UserData extends BaseModel
{
    /**
     *
     */
    public function saveUserData(): void
    {
        $data = $this->getUserData();
        $count = count($data) - 1;

        Console::startProgress(0, $count, __FUNCTION__);
        foreach ($data as $i => $item) {
            $this->clearUserData($item);
            $this->saveUser($item);
            $this->saveUserAuthAccess($item);
            //$this->assaineRole($item);
//            $this->saveBalance($item);
            //Yii::info('User item saved - '.$item['id']);
            Console::updateProgress($i, $count, __FUNCTION__);
        }
        Console::endProgress();
    }

    /**
     * @param array $item
     * @throws TransferException
     */
    private function saveBalance(array $item): void
    {
        $addressBalanceClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);
        $addressBalanceModel = new $addressBalanceClass;

        $addressBalanceModel->address = $item['address'];
        $addressBalanceModel->balance = $item['balance'];
        $addressBalanceModel->lastSync = Yii::$app->formatter->asDatetime(time(), \App\Components\BaseModel::DB_DATE_TIME_FORMAT);

        if (!$addressBalanceModel->save()) {
            Yii::error($addressBalanceModel->getErrors());
            throw new TransferException('Cant save balance');
        }
    }


    /**
     * @param array $item
     * @throws TransferException
     */
    private function saveUser(array $item): void
    {
        $userClass = UserModelFactory::getClass(UserModelFactory::USER);
        $userModel = new $userClass;
        $userModel->detachBehavior('timestamp');

        $userModel->active = $item['status'];
        $userModel->notification = $item['email_notification'];
        $userModel->email = $item['email'];
        $userModel->countryCode = $item['country'];
        $userModel->lastSync = Yii::$app->formatter->asDatetime(time(), \App\Components\BaseModel::DB_DATE_TIME_FORMAT);
        $userModel->createdAt = $item['created'];
        $userModel->moderatorId = 0; // todo: refactor to default user
        $userModel->role = User::USER_ROLE;

        if (!$userModel->save()) {
            Yii::error($userModel->getErrors());
            throw new TransferException('Cant save user');
        }

        $this->logUser($userModel->id, (int)$item['id']);
    }

    /**
     * @param array $item
     * @throws TransferException
     */
    private function saveUserAuthAccess(array $item): void
    {
        $userAuthAccessClass = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS);
        $userAuthAccessModel = new $userAuthAccessClass;

        $userAuthAccessModel->userId = $this->getNewUserId((int) $item['id']);
        $userAuthAccessModel->address = $item['address'];
        $userAuthAccessModel->password = 'password';
        $userAuthAccessModel->old_password = $item['password'];
        $userAuthAccessModel->is_password_changed = 0;
        $userAuthAccessModel->tfauthCode = $item['twofa_secret'];
        $userAuthAccessModel->tfauthActive = $item['twofa_enabled'];
        $userAuthAccessModel->lastEnter = Yii::$app->formatter->asDatetime(time(), \App\Components\BaseModel::DB_DATE_TIME_FORMAT);

        if (!$userAuthAccessModel->save()) {
            Yii::error($userAuthAccessModel->getErrors());
            throw new TransferException('Cant save user auth access');
        }
    }

    /**
     * @param array $item
     */
    private function clearUserData(array $item): void
    {
        $ids = $this->deleteUserAuthAccessByAddress($item['address']);
        $this->deleteUserByIds($ids);
//        $this->deleteAddressBalanceByAddress($item['address']);
        $this->deleteParkingsByUserIds($ids);
    }

    /**
     * @param $address
     * @return array
     */
    private function deleteUserAuthAccessByAddress($address): array
    {
        $ids = [];

        $userAuthAccessClass = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS);
        $userAuthAccessModel = $userAuthAccessClass::find()->where(['address' => $address])->all();

        foreach ($userAuthAccessModel as $modelItem) {
            $ids[] = $modelItem->userId;
            $modelItem->delete();
        }

        return $ids;
    }

    /**
     * @param array $ids
     */
    private function deleteUserByIds(array $ids): void
    {
        $userClass = UserModelFactory::getClass(UserModelFactory::USER);
        $userClass::deleteAll(['id' => $ids]);
    }

    /**
     * @param $address
     */
    private function deleteAddressBalanceByAddress($address): void
    {
        $addressBalanceClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);
        $addressBalanceModel = $addressBalanceClass::find()->where(['address' => $address])->one();

        if ($addressBalanceModel != null) {
            $addressBalanceModel->delete();
        }
    }

    /**
     * @param $ids
     */
    private function deleteParkingsByUserIds($ids): void
    {
        $parkingIds = [];

        $parkingClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);
        $parkingModels = $parkingClass::find()->where(['userId' => $ids])->all();

        foreach ($parkingModels as $parkingModel) {
            $parkingIds[] = $parkingModel->id;
        }

        $this->deleteParkingLogsByIds($parkingIds);

        foreach ($parkingModels as $parkingModel) {
            $parkingIds[] = $parkingModel->delete();
        }
    }

    private function deleteParkingLogsByIds($ids): void
    {
        $parkingLogClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_LOG);
        $parkingLogClass::deleteAll(['parkingId' => $ids]);
    }

    /**
     * @param int $newId
     * @param int $oldId
     */
    private function logUser(int $newId, int $oldId): void
    {
        UserProxy::getInstance()->saveId($oldId, $newId);
    }

    /**
     * @param int $oldId
     * @return int
     */
    private function getNewUserId(int $oldId): int
    {
        return UserProxy::getInstance()->getId($oldId);
    }

    /**
     * @return array
     */
    public function getUserData(): array
    {
        $data = $this->getFile('user.cvs');

        return $this->transformData($data, [
            'id',
            'address',
            'verify_address',
            'password',
            'balance',
            'status',
            'created',
            'twofa_enabled',
            'twofa_passed',
            'twofa_secret',
            'email_notification',
            'email',
            'country',
            'authKey',
            'notification_last_id',
            'last_sync',
            'role'
        ]);
    }

    /**
     * @param array $item
     * @throws TransferException
     */
    private function assaineRole(array $item): void {
        $role = new AuthAssignment();
        $role->user_id = (string)$this->getNewUserId((int) $item['id']);
        $role->item_name = User::USER_ROLE;
        $role->created_at = time();
        if(!$role->save()) {
            throw new TransferException('Error to assignment user '.$role->user_id.' role USER.#'.Json::encode($role->getErrors()));
        }
    }
}
