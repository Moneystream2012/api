<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Parking;
use app\models\Payout;
use app\models\User;
use yii\base\UserException;
use yii\base\Module;


class CronController extends ServiceController {
	/** @var */
	private $_prepareAddress = 'XGNoQsHCQkECjXDKkC1QjCQoZj7kj3KwqB';

	/** @var */
	private $_prepareErrorLog = 'prepare.payout.error.log';
	private $_payoutErrorLog = 'payout.error.log';
	private $_processName = '';

	/** @var int $_parkingProcessLimit How many parkings process per one action call. */
	private $_parkingProcessLimit = 10;

	/** @var \app\services\UserService $_userService */
	private $_userService = null;

	/** @var \app\services\MinexcoinService $_mnxService */
	private $_mnxService = null;

	/** @var \app\services\PayoutTransactionService $_payoutTxService */
	private $_payoutTxService = null;

	/** @var \app\services\PayoutService $_payoutService */
	private $_payoutService = null;

	/** @var \app\services\ParkingService $_parkingService */
	private $_parkingService = null;


	/**
	 * Constructor.
	 */
	public function __construct($id, Module $module, array $config = [])
	{
		parent::__construct($id, $module, $config);
		$this->_userService = $this->getService('User');
		$this->_parkingService = $this->getService('Parking');
		$this->_mnxService = $this->getService('Minexcoin');
		$this->_payoutTxService = $this->getService('PayoutTransaction');
		$this->_payoutService = $this->getService('Payout');
	}


	/**
	 * Prepare payout.
	 */
	public function actionPreparePayout() {
		$this->_processName = 'prepare_payout';
		$this->makeLockFile();

		/** @var \app\services\UserService $userService */
		$userService = $this->getService('User');

		/** @var \app\services\MinexcoinService $mnxService */
		$mnxService = $this->getService('Minexcoin');

		/** @var \app\services\PayoutTransactionService $payoutTxService */
		$payoutTxService = $this->getService('PayoutTransaction');

		/** @var \app\services\ParkingService $parkingService */
		$parkingService = $this->getService('Parking');

		$fatalError = false;
		$usersCache = [];
		$cacheSize = 50;

		// Wait adjustment
		$minWaitTime = 0.1;
		$maxWaitTime = 10;
		$waitStep = 0.1;
		$waitIn = $minWaitTime;

		while (!$fatalError) {
			$this->checkRunning();

			// Get parking without prepared transaction.
			$parkings = $parkingService->getActiveParkingsWithNotPreparedPayoutTx(1);

			if (count($parkings) == 0) {
				$this->wait($waitIn);
				if ($waitIn < $maxWaitTime) $waitIn=$maxWaitTime;
				$this->logError($this->_prepareErrorLog, 'Parking not found');
				continue;
			}

			foreach ($parkings as $parking) {
				// If no parking with ready to transaction preparation.
				if ($parking->created + floor(($parking->expired-$parking->created)/2) > time()) {
					$this->wait($waitIn);
					if ($waitIn < $maxWaitTime) $waitIn+=$waitStep;
					break;
				}

				$waitIn = $minWaitTime;

				// Control the cache size.
				if (count($usersCache) > $cacheSize)
					array_shift($usersCache);

				// Find user.
				if (!isset($usersCache[$parking->user_id])) {
					$user = $userService->find('id = :uid', [':uid'=>$parking->user_id]);
					if ($user == null) continue;
					$usersCache[$parking->user_id] = $user;
				} else
					$user = $usersCache[$parking->user_id];

				if (!$this->isUserBalanceValid($user, $this->_prepareErrorLog)) {
					$this->logError($this->_prepareErrorLog, 'User balance fault: '.$user->id);
					$parking->status = 0;
					$parking->save();
					continue;
				}

				// ------------------------------- Prepare
				// Prepare transaction.
				$hexData = $mnxService->prepareTransaction($this->_prepareAddress, $parking->return_amount);
				if ($hexData['status'] == 0) {
					$this->logError($this->_prepareErrorLog, $this->getErrorFromResponse($hexData, 'Cant prepare raw transaction [address: '.$this->_prepareAddress.'] [amount: '.$parking->return_amount.']'));
					$this->wait($waitIn);
					break;
				}


				// ------------------------------- Check
				$tx = $mnxService->decodeRawTransaction($hexData['data']);
				if ($tx['status'] == 0) {
					$this->logError($this->_prepareErrorLog, $this->getErrorFromResponse($tx, 'Cant decode raw transaction [hex: '.$hexData['data'].']'));
					$this->wait($waitIn);
					break;
				}


				// ------------------------------- Create record
				// Record transaction.
				$dbTransaction = Yii::$app->db->beginTransaction();
				$payoutTransaction = $payoutTxService->add($parking->id, $tx['data']['txid']);

				// If something wrong.
				if (!$payoutTransaction) {
					$this->logError($this->_prepareErrorLog, 'Cant create payout transaction [Parking id: '.$parking->id.']');
					$dbTransaction->rollback();
					continue;
				}


				// -------------------------------- Send
				// Try to send transaction.
				$txData = $mnxService->sendTransaction($hexData['data']);
				if ($txData['status'] == 0) {
					$this->logError($this->_prepareErrorLog, $this->getErrorFromResponse($txData, 'Cant send transaction [hex: '.$hexData['data'].']'));
					$dbTransaction->rollback();
					continue;
				}

				// If txid was changed due to sending transaction.
				if ($txData['data'] != $payoutTransaction->txid) {
					$payoutTransaction->txid = $txData['data'];
					if (!$payoutTransaction->save())
						$this->logError($this->_prepareErrorLog, 'Cant update payout transaction id: [ID: '.$payoutTransaction->txid.'] [txid: '.$txData['data'].']');
				}

				// Mark parking as has prepared transaction.
				$parking->payout_prepared = 1;
				$parking->save();


				// Save all this shit.
				$dbTransaction->commit();

				// Lets wait a bit.
				$this->wait($waitIn);
				if ($waitIn < $maxWaitTime) $waitIn+=$waitStep;
			}
		}
	}



	/**
	 * Check if available completed parkings and create payout.
	 */
	public function actionCreatePayout() {
		$this->_processName = 'create_payout';
		$this->makeLockFile();

		$userService = $this->getService('User');
		$mnxService = $this->getService('Minexcoin');
		$payoutTxService = $this->getService('PayoutTransaction');
		$parkingService = $this->getService('Parking');
		$payoutService = $this->getService('Payout');

		$fatalError = false;
		$fatalErrorLock = 5;
		$usersCache = [];
		$cacheSize = 50;

		// Wait adjustment
		$minWaitTime = 1;
		$maxWaitTime = 10;
		$waitStep = 0.1;
		$waitIn = $minWaitTime;

		while (!$fatalError) {
			$this->checkRunning();

			// Get parking with prepared transaction.
			/** @var \app\models\Parking[] $parkings */
			$parkings = $parkingService->getActiveParkingsWithPreparedPayoutTx(1);

			if (count($parkings) == 0) {
				$waitIn=$maxWaitTime;
				$this->wait($waitIn);
				continue;
			}

			foreach ($parkings as $parking) {
				if ($parking->expired > time()+($maxWaitTime+$minWaitTime)) {
					$this->wait($waitIn=$maxWaitTime);
					break;
				}

				if ($parking->expired > time()) {
					$this->wait($waitIn=$minWaitTime);
					break;
				}


				// Control the cache size.
				if (count($usersCache) > $cacheSize)
					array_shift($usersCache);

				// Find user.
				if (!isset($usersCache[$parking->user_id])) {
					$user = $userService->find('id = :uid', [':uid'=>$parking->user_id]);
					if ($user == null) continue;
					$usersCache[$parking->user_id] = $user;
				} else
					$user = $usersCache[$parking->user_id];

				if (!$this->isUserBalanceValid($user, $this->_payoutErrorLog)) {
					$parking->status = 0;
					$parking->save();
					$this->log($this->_payoutErrorLog, 'Parking was canceled: '.$parking->id);
					continue;
				}

				$transaction = $payoutTxService->find('parking_id = :pid', [':pid'=>$parking->id]);
				if (!$transaction) {
					$this->logError($this->_payoutErrorLog, 'Prepared transaction not found [Parking id: '.$parking->id.']');
					if (--$fatalErrorLock < 1) $fatalError = true;
					$this->wait($waitIn=$minWaitTime);
					break;
				}

				$dbTransaction = Yii::$app->db->beginTransaction();

				// ----------------------------------------- Send transaction
				$txid = $mnxService->sendTransactionRemote($transaction->txid, $usersCache[$parking->user_id]->address);
				if ($txid['status'] == 0) {
					$this->logError($this->_payoutErrorLog, $this->getErrorFromResponse($txid, 'Cant send remote transaction'));
					if ($fatalErrorLock-- < 1) $fatalError = true;
					$dbTransaction->rollback();
					$this->wait($waitIn=$minWaitTime);
					break;
				}

				// ----------------------------------------- Create payout
				$payout = $payoutService->add($parking->id, $txid['data'], $parking->user_id, $parking->return_amount);
				if (!$payout) {
					$this->logError($this->_payoutErrorLog, 'Payout cant be added');
					if (--$fatalErrorLock < 1) $fatalError = true;
					$dbTransaction->rollback();
					$this->wait($waitIn=$minWaitTime);
					break;
				}

				// ----------------------------------------- Update parking
				$parking->status = 2;
				if (!$parking->save()) {
					$this->logError($this->_payoutErrorLog, 'Parking cant be updated: '.$parking->id);
					if (--$fatalErrorLock < 1) $fatalError = true;
					$dbTransaction->rollback();
					$this->wait($waitIn=$minWaitTime);
					break;
				}

				$dbTransaction->commit();

				print("Transaction sent\n");
				$waitIn=$minWaitTime;
			}
			$fatalErrorLock = 5;
		}

		print('Payout creator finished job'."\n");
	}



	/**
	 * Control creation of payouts.
	 * Runs by cron once per minute.
	 */
	public function actionControlPayout()
	{
		// -------------------- Create payout ----------------------


		$this->_processName = 'create_payout';
		if ($this->makeLockFile()) {
			// Get expired parkings with prepared payouts.
			/** @var Parking[] $parkings */
			$parkings = $this->_parkingService->getActiveParkingsWithPreparedPayoutTx($this->_parkingProcessLimit);

			// Create payouts.
			if (count($parkings) > 0) {
				foreach ($parkings as $parking) {
					$this->logError($this->_payoutErrorLog, 'Creating runs');
					try {
						$this->createPayoutForParking($parking);
					} catch (UserException $e) {
						$this->logError($this->_payoutErrorLog, $e->getMessage());
					}
				}
			}

			$this->removeLockFile();
		}


		// -------------------- Prepare payout ----------------------


		$this->_processName = 'prepare_payout';
		if (!$this->makeLockFile())
			die('Another process is running');

		// Get half-expired parkings.
		/** @var \app\models\Parking[] $parkings */
		$parkings = $this->_parkingService->getActiveParkingsWithNotPreparedPayoutTx($this->_parkingProcessLimit);

		// Prepare payouts.
		if (count($parkings) > 0) {
			foreach ($parkings as $parking) {
				$this->logError($this->_prepareErrorLog, 'Preparing runs');
				try {
					$this->preparePayoutForParking($parking);
				} catch (UserException $e) {
					$this->logError($this->_prepareErrorLog, $e->getMessage());
				}
			}
		}

		$this->removeLockFile();
	}



	/**
	 * Prepare payout for parking.
	 * Check if parking is valid and create transaction to payout server.
	 *
	 * @throws UserException
	 * @param Parking $parking
	 */
	private function preparePayoutForParking(Parking $parking)
	{
		if ($parking->created + floor(($parking->expired-$parking->created)/2) > time())
			return;

		/** @var \app\models\User $user */
		$user = $this->_userService->find('id = :uid', [':uid'=>$parking->user_id]);
		if ($user == null)
			throw new UserException('User not found for parking: '.$parking->id);

		if (!$this->isUserBalanceValid($user)) {
			$parking->status = 0; // TODO: Change status for unique for this situation.
			$parking->save();
			throw new UserException('User balance is not enough to prepare payout of the parking: '.$parking->id
				.' [Parking balance: '.number_format($parking->amount, 8).']'
				.'[User balance: '.number_format($user->balance, 8).']');
		}

		// ------------------------------- Prepare
		// Prepare transaction.
		$hexData = $this->_mnxService->prepareTransaction($this->_prepareAddress, $parking->return_amount);
		if ($hexData['status'] == 0)
			throw new UserException('Cant prepare raw transaction [address: '
				.$this->_prepareAddress.'] [amount: '.$parking->return_amount.']');


		// ------------------------------- Check
		$tx = $this->_mnxService->decodeRawTransaction($hexData['data']);
		if ($tx['status'] == 0)
			throw new UserException('Cant decode raw transaction [hex: '.$hexData['data'].']');


		// ------------------------------- Create record
		// Record transaction.
		$dbTransaction = Yii::$app->db->beginTransaction();
		$payoutTransaction = $this->_payoutTxService->add($parking->id, $tx['data']['txid']);

		// If something wrong.
		if (!$payoutTransaction) {
			$dbTransaction->rollback();
			throw new UserException('Cant create payout transaction [Parking id: '.$parking->id.']');
		}


		// -------------------------------- Send
		// Try to send transaction.
		$txData = $this->_mnxService->sendTransaction($hexData['data']);
		if ($txData['status'] == 0) {
			$dbTransaction->rollback();
			throw new UserException('Cant send transaction [hex: '.$hexData['data'].']');
		}

		// If txid was changed due to sending transaction.
		if ($txData['data'] != $payoutTransaction->txid) {
			$payoutTransaction->txid = $txData['data'];
			if (!$payoutTransaction->save()) {
				$dbTransaction->commit();
				throw new UserException('Cant update payout transaction id: [ID: ' . $payoutTransaction->txid . '] [txid: ' . $txData['data'] . ']');
			}
		}

		// Mark parking as has prepared transaction.
		$parking->payout_prepared = 1;
		$parking->save();

		$dbTransaction->commit();
	}



	/**
	 * Create payout for parking.
	 * Check if parking is valid and create transaction to user address.
	 *
	 * @throws UserException
	 * @param Parking $parking
	 */
	private function createPayoutForParking(Parking $parking)
	{
		// Find user.
		if (($user = $this->_userService->find('id = :uid', [':uid'=>$parking->user_id])) == null)
			throw new UserException('User not found for parking: '.$parking->id);

		if (!$this->isUserBalanceValid($user))
		{
			$parking->status = 0;
			$parking->save();
			throw new UserException('User balance is not enough to close the parking: '.$parking->id
				.' [Parking balance: '.number_format($parking->amount, 8).']'
				.'[User balance: '.number_format($user->balance, 8).']');
		}

		if (!($transaction = $this->_payoutTxService->find('parking_id = :pid', [':pid'=>$parking->id])))
			throw new UserException('Prepared transaction not found [Parking id: '.$parking->id.']');

		$dbTransaction = Yii::$app->db->beginTransaction();

		// ----------------------------------------- Send transaction
		$txid = $this->_mnxService->sendTransactionRemote($transaction->txid, $user->address);
		if ($txid['status'] == 0) {
			$dbTransaction->rollBack();
			throw new UserException('Cant send remote transaction: ' . $transaction->txid);
		}

		// ----------------------------------------- Create payout
		if (!($this->_payoutService->add($parking->id, $txid['data'], $parking->user_id, $parking->return_amount))) {
			$dbTransaction->rollBack();
			throw new UserException('Payout cant be added');
		}

		// ----------------------------------------- Update parking
		$parking->status = 2;
		if (!$parking->save()) {
			$dbTransaction->rollBack();
			throw new UserException('Parking cant be closed: ' . $parking->id);
		}

		$dbTransaction->commit();

		print("Transaction sent\n");
	}


	/**
	 * Log actions.
	 *
	 * @param string $fileName
	 * @param string $data
	 */
	public function log($fileName, $data) {
		if (($f = fopen(__DIR__ . '/../runtime/log/' .$fileName, 'a+')) === false)
			throw new Exception('Cant open log file: '.__DIR__.'/../runtime/log/'.$fileName);

		fputs($f, '[Action]['.date('d.m.y H:i:s').'] '.$data."\n");
		fclose($f);
	}



	/**
	 * Freeze running the script at some time.
	 *
	 * @internal
	 * @param float $period Number of seconds
	 */
	private function wait($period = 1) {
		usleep($period * 1000000);
	}



	/**
	 * Write into error log.
	 *
	 * @param string $log
	 * @param string $error
	 */
	private function logError($log, $error) {
		if (($f = fopen(__DIR__ . '/../runtime/log/' .$log, 'a+')) === false)
			throw new Exception('Cant open log file: '.__DIR__.'/../runtime/log/'.$log);

		fputs($f, '['.date('d.m.y H:i:s').'] '.$error."\n");
		fclose($f);
	}



	/**
	 * Get error from response.
	 *
	 * @param array $response
	 * @param string $default
	 * @return string
	 */
	private function getErrorFromResponse($response, $default) {
		if (isset($response['error']))
			return $response['error'];
		else
			return $default;
	}



	private function isUserBalanceValid($user, $log = null) {
		$parkingService = $this->getService('Parking');
		$userService = $this->getService('User');

		$userBalance = $userService->syncBalance($user);
		$parkingsInfo = $parkingService->getInfo($user);


		if (!$userBalance['status']) {
			if ($log != null) $this->log($log, "User balance not received");
			return false;
		}

		if ($log != null) $this->log($log, 'Balances [Address: '.$user->address.']: '.$userBalance['data'].' : '.$parkingsInfo['parked']);

		return round((float)$userBalance['data'], 8) >= round((float)$parkingsInfo['parked'], 8);
	}



	/**
	 * Try to create lock file.
	 *
	 * @param string $processName
	 * @return boolean
	 */
	private function makeLockFile($processName = '') {
		$path = __DIR__ . '/../runtime/';

		if (file_exists($path.$this->_processName.'.lock')) {
			print('Process is already running'."\n");
			return false;
		}

		if (!@file_put_contents($path.$this->_processName.'.lock', getmypid())) {
			print('Cant create lock file'."\n");
			return false;
		}

		print('Lock file created'."\n");
		return true;
	}



	/**
	 * Check if actual process running.
	 *
	 * @param string $processName
	 */
	private function checkRunning($processName = '') {
		if (!file_exists($this->_processName.'.lock'))
			die('Lock file not found - process ended'."\n");

		$pid = file_get_contents($this->_processName.'.lock');
		if ($pid != getmypid())
			die('Lock file contains another pid - porecess ended'."\n");
	}



	/**
	 * Remove lock file while process ends.
	 */
	private function removeLockFile($processName = '') {
		$path = __DIR__ . '/../runtime/';

		if (file_exists($path.$this->_processName.'.lock') && !unlink($path.$this->_processName.'.lock')) {
			print('Cant remove lock file'."\n");
			return false;
		}

		print('Lock file removed'."\n");
		return true;
	}
}
