<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 05.10.17
 * Time: 18:42
 */

namespace App\Commands;

use App\Commands\Transfer\Models\Parking;
use App\Commands\Transfer\Models\Payout;
use App\Commands\Transfer\Models\Subscriber;
use App\Commands\Transfer\Models\UserAuth;
use App\Commands\Transfer\Models\UserData;
use yii\console\Controller;

class TransferController extends Controller
{
    protected $parkingTypesTable = [];
    protected $currentParkingTypesTable = [];
    protected $parkingTable = [];

    /**
     * todo: видалення логу транзакцій крім останньої
     * @throws \Exception
     */
    public function actionIndex(): void
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $userData = new UserData();
            $userData->saveUserData();

            $parkingData = new Parking();
            $parkingData->saveParkingData();

            $payoutData = new Payout();
            $payoutData->savePayoutData();

            $userAuth = new UserAuth();
            $userAuth->createUserAssignments();

            $subscriber = new Subscriber();
            $subscriber->saveSubscriber();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
