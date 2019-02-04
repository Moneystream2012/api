<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 16.10.17
 * Time: 15:16
 */

namespace tests\unit\Modules\Finance\Components;

use App\Modules\Finance\Components\BalanceChange;
use App\Modules\Finance\Models\FinanceAddressBalance;
use App\Modules\Finance\Models\FinanceAddressBalanceLog;
use tests\fixtures\Explorer\ExplorerTransactionFixture;
use tests\fixtures\Finance\FinanceAddressBalanceFixture;
use tests\fixtures\Finance\FinanceAddressBalanceLogFixture;

/**
 * Class BalanceChangeTest
 * @package tests\unit\Modules\Finance\Components
 */
class BalanceChangeTest extends \Codeception\Test\Unit
{

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $changes;

	/**
	 * @var \App\Modules\Finance\Components\BalanceChange
	 */
	protected $balanceChange;

	public function _fixtures() {
		return [
			ExplorerTransactionFixture::class,
			FinanceAddressBalanceFixture::class,
			FinanceAddressBalanceLogFixture::class,
		];
	}

	protected function setUp() {
		$this->balanceChange = new BalanceChange();
		$this->changes = [
			'XVBcuktbPLr7QqFwBzEySjKFv5ZLwuBHhm' => [ // вже буде в таблиці, провіряємо роботу апдейту
				'address'      => 'XVBcuktbPLr7QqFwBzEySjKFv5ZLwuBHhm',
				'balance'      => -1.946,
				'status'       => 'direct',
				'lastSync'     => '2017-10-13 15:49:25',
				'transactions' => [
					[
						'transactionId' => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
						'amount'        => -1.946
					]
				]
			],
			'XVFYK9MgdMDhYwwnTsEkqBFvUytC5QtWE4' => [
				'address'      => 'XVFYK9MgdMDhYwwnTsEkqBFvUytC5QtWE4',
				'balance'      => 1,
				'status'       => 'direct',
				'lastSync'     => '2017-10-13 15:49:25',
				'transactions' => [
					[
						'transactionId' => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
						'amount'        => 0.5
					],
					[
						'transactionId' => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
						'amount'        => 0.5
					]
				]
			],
			'XaTs7jSGVFmx8Y5VRvsuikMLzFq8r9iXRN' => [
				'address'      => 'XaTs7jSGVFmx8Y5VRvsuikMLzFq8r9iXRN',
				'balance'      => 0.096,
				'status'       => 'direct',
				'lastSync'     => '2017-10-13 15:49:25',
				'transactions' => [
					[
						'transactionId' => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
						'amount'        => 0.054
					],
					[
						'transactionId' => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
						'amount'        => 0.042
					]
				]
			],
			'XHiXq1HkoJTK2sPjfPXU4cz2bwhqGeRb6u' => [
				'address'      => 'XHiXq1HkoJTK2sPjfPXU4cz2bwhqGeRb6u',
				'balance'      => 1.958,
				'status'       => 'direct',
				'lastSync'     => '2017-10-13 15:49:25',
				'transactions' => [
					[
						'transactionId' => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
						'amount'        => 1.958
					]
				]
			],
			'coinbase' => [
				'address' => 'coinbase'
			]
		];

		parent::setUp();
	}

	protected function tearDown() {
		$this->balanceChange = null;
		parent::tearDown();
	}

	public function testBalanceChanges() {
		$this->balanceChange->proceed($this->changes);

		$this->checkBalances();
		$this->checkLogs();
	}

	private function checkBalances() {
		$this->tester->seeRecord(FinanceAddressBalance::class, [
			'address' => 'XVBcuktbPLr7QqFwBzEySjKFv5ZLwuBHhm',
			'balance' => 13.054
		]);

		$this->tester->seeRecord(FinanceAddressBalance::class, [
			'address' => 'XVFYK9MgdMDhYwwnTsEkqBFvUytC5QtWE4',
			'balance' => 1
		]);

		$this->tester->seeRecord(FinanceAddressBalance::class, [
			'address' => 'XaTs7jSGVFmx8Y5VRvsuikMLzFq8r9iXRN',
			'balance' => 0.096
		]);

		$this->tester->seeRecord(FinanceAddressBalance::class, [
			'address' => 'XHiXq1HkoJTK2sPjfPXU4cz2bwhqGeRb6u',
			'balance' => 1.958
		]);
	}

	private function checkLogs() {
		$this->tester->seeRecord(FinanceAddressBalanceLog::class, [
			'addressBalanceId' => 1,
			'transactionId'    => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
			'amount'           => -1.94600000,
			'balance'          => 13.05400000,
			'status'           => 'direct',
			'createdAt'        => '2017-10-13 15:49:25',
		]);

		$this->tester->seeRecord(FinanceAddressBalanceLog::class, [
			'addressBalanceId' => 2,
			'transactionId'    => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
			'amount'           => 0.50000000,
			'balance'          => 0.50000000,
			'status'           => 'direct',
			'createdAt'        => '2017-10-13 15:49:25',
		]);

		$this->tester->seeRecord(FinanceAddressBalanceLog::class, [
			'addressBalanceId' => 2,
			'transactionId'    => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
			'amount'           => 0.50000000,
			'balance'          => 1.00000000,
			'status'           => 'direct',
			'createdAt'        => '2017-10-13 15:49:25',
		]);

		$this->tester->seeRecord(FinanceAddressBalanceLog::class, [
			'addressBalanceId' => 3,
			'transactionId'    => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
			'amount'           => 0.05400000,
			'balance'          => 0.05400000,
			'status'           => 'direct',
			'createdAt'        => '2017-10-13 15:49:25',
		]);

		$this->tester->seeRecord(FinanceAddressBalanceLog::class, [
			'addressBalanceId' => 3,
			'transactionId'    => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
			'amount'           => 0.04200000,
			'balance'          => 0.09600000,
			'status'           => 'direct',
			'createdAt'        => '2017-10-13 15:49:25',
		]);

		$this->tester->seeRecord(FinanceAddressBalanceLog::class, [
			'addressBalanceId' => 4,
			'transactionId'    => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
			'amount'           => 1.95800000,
			'balance'          => 1.95800000,
			'status'           => 'direct',
			'createdAt'        => '2017-10-13 15:49:25',
		]);
	}
}
