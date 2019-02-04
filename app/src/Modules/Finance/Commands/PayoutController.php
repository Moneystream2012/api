<?php
/**
 * @author Tarasenko Andrii
 * @date: 17.10.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Commands;

use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Components\ParkingService;
use App\Modules\Finance\Components\PayoutService;
use App\Modules\Finance\Exceptions\PayoutControllerException;
use App\Modules\Finance\Models\FinanceTransaction;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

/**
 * Need to be handles by process manager
 * Can throw exception and stop working
 *
 * Class PayoutController
 * @package App\Modules\Finance\Commands
 */
class PayoutController extends Controller
{
    private const LOG_CATEGORY = 'payout';

    private $maxErrorAttempts = 100;
    private $maxSleep = 10;

    /**
     * @var ParkingService
     */
    private $parking;

    /**
     * @var PayoutService
     */
    private $payout;

    /**
     * @var int
     */
    private $errorAttempts = 0;

    public function actionRun(int $maxAttempts = null, int $maxSleep = null): void {

        if (!empty($maxAttempts)) {
            $this->setMaxAttempts($maxAttempts);
        }

        if (!empty($maxSleep)) {
            $this->setMaxSleep($maxSleep);
        }

        $this->registerPCNTLSignals();

        $this->startPayoutOfParkings();
    }

    public function setMaxAttempts(int $attempts): void {
        $this->maxErrorAttempts = $attempts;
        $this->stdout('Max error attempts changed to '. $attempts . "\n", Console::FG_GREEN);
    }

    public function setMaxSleep(int $maxSleep): void {
        $this->maxSleep = $maxSleep;
        $this->stdout('Max sleep time changed to '. $maxSleep . ' second(s)' . "\n", Console::FG_GREEN);
    }

    public function stop($sign) {
        \Yii::info('Handle '.$sign.' PCNTL signal. System shutdown');
        die(0);
    }

    private function startPayoutOfParkings() {
        Yii::info("Start payout expired parkings loop.", self::LOG_CATEGORY);

        $this->parking = new ParkingService();
        $this->payout = new PayoutService();

        $this->payout->transactionFee = Yii::$app->params['transactionFee'];

        $counter = 1;

        while (true) {
            $parkings = $this->parking->getExpiredParkings(5);

            if (empty($parkings)) {
                $this->console('No available expired parkings for payout. ', Console::FG_YELLOW);

                $counter = $this->await($counter, true);
                continue;
            }

            [$parkings, $parkingsForCancel] = $this->filterParkingsByUserBalance($parkings);

            $this->parking->cancelParkings($parkingsForCancel);

            $userAddressesById = $this->parking->getUserAddresses($parkings);

            list($dataForPayoutTransaction, $dataForDbPayoutTransactions) = $this->getPayoutData($parkings, $userAddressesById);

            if (empty($dataForPayoutTransaction)) {
                Yii::info($parkings, self::LOG_CATEGORY);
                Yii::info($userAddressesById, self::LOG_CATEGORY);

                throw new PayoutControllerException('No payout data for exist expired parkings! Logic error');
            }

            $this->sendAndSaveDataInDbTransaction($dataForDbPayoutTransactions, $dataForPayoutTransaction, $parkings);

            $this->errorAttempts = 0;
            $counter = $this->await($counter);
        }
    }

    private function filterParkingsByUserBalance(array $notCheckedParkings): array {

        $addresses = $this->parking->getUserAddresses($notCheckedParkings);

        $balances = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE)::find()->where(['address' => $addresses])->asArray()->all();

        $formattedBalances = ArrayHelper::map($balances, 'address', 'balance');

        $parkingsForCancel = $this->parking->getParkingsForCancel($formattedBalances);

        $parkings = $this->filterParkings($notCheckedParkings, $parkingsForCancel);

        return [$parkings, $parkingsForCancel];
    }

    private function filterParkings(array $parkingsToFilter, array $parkingsToRemove): array {
        $result = [];

        foreach ($parkingsToFilter as $item) {
            $find = false;
            foreach ($parkingsToRemove as $inex => $remove) {
                if ($item['id'] == $remove['id']) {
                    unset($parkingsToRemove[$inex]);
                    $find = true;
                    break;
                }
            }

            if(!$find) {
                $result[] = $item;
            }
        }

        return $result;
    }

    private function sendAndSaveDataInDbTransaction($dataForDbPayoutTransactions, $dataForPayoutTransaction, $parkings): void {
        $transaction = \Yii::$app->db->beginTransaction();

        try{

            $blankTransactionIds = $this->payout->saveBlankTransactions($dataForDbPayoutTransactions);
            $this->parking->completeParkings($parkings);
            $hash = $this->payout->sendPayoutTransaction($dataForPayoutTransaction);

            Yii::info($blankTransactionIds);

            // send transaction to block-chain

            if (empty($hash)) {
                Yii::info($dataForPayoutTransaction, self::LOG_CATEGORY);

                $this->deleteTransactions($blankTransactionIds);

                throw new PayoutControllerException('Couldn\'t sent transaction to block-chain. Aborting payouts!');
            }

            $this->console('Transaction send to block chain with hash: ' . $hash . "\n");

            $this->payout->updateTransactionsWithLog($blankTransactionIds, $hash);

            $transaction->commit();

        } catch (\Throwable $exception) {
            $transaction->rollBack();
            throw new $exception;
        }
    }

    private function deleteTransactions(array $ids): void {
        /* @var FinanceTransaction $class */
        $class = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        $class::deleteAll(['id' => $ids]);
    }

    /**
     * @param array $parkings
     * @param array $userAddressesById
     * @return array
     */
    private function getPayoutData(array $parkings, array $userAddressesById): array {
        $dataForPayoutTransaction = [];
        $dataForDbPayoutTransactions = [];

        /* @var FinanceTransaction $class */
        $class = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        foreach ($parkings as $parking) {
            $userId = $parking['userId'];
            $parkingId = $parking['id'];
            $amount = $this->parking->getPayoutAmount($parking);

            if (!key_exists($userId, $userAddressesById)) {
                Yii::info(
                    'Couldn\'t find user auth in db for id:'.$userId.'! Parking with id: '. $parking['id'] . ' skipped!',
                    self::LOG_CATEGORY
                );

                continue;
            }

            $address = $userAddressesById[$userId];
            $dataForPayoutTransaction[$address] = $amount;
            $dataForDbPayoutTransactions[] = [
                'parkingId' => $parkingId,
                'amount' => $amount,
                'fee' => $this->payout->transactionFee,
                'status' => $class::TYPE_BLANK,
            ];
        }

        return [$dataForPayoutTransaction, $dataForDbPayoutTransactions];
    }

    /**
     * @param int $counter
     * @param bool $increment
     * @return int
     */
    private function await(int $counter, bool $increment = false): int {
        if ($counter > $this->maxSleep || !$increment) {
            $counter = 1;
        }

        $this->console('Waiting ');
        $this->console(''.$counter.' second(s)', Console::FG_GREEN, Console::BOLD);
        $this->console(' for new expired parkings.'."\n");

        sleep($counter);

        return $increment ? ++$counter : $counter;
    }

    private function registerPCNTLSignals(): void {
        declare(ticks = 1) {
            pcntl_signal(\SIGTERM, [$this, 'stop']);
            pcntl_signal(\SIGINT,  [$this, 'stop']);
            pcntl_signal(\SIGUSR1, [$this, 'stop']);
            pcntl_signal(\SIGHUP,  [$this, 'stop']);
        }
        \Yii::trace('Register PCNTL handler for SIGTERM,SIGINT,SIGUSR1,SIGHUP');
    }

    private function console(string $message): void {
        if (YII_ENV_DEV) {
            $args = func_get_args();
            call_user_func_array([$this, 'stdout'], $args);
        }
    }
}
