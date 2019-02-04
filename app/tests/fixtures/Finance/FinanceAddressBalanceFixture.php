<?php
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Database\FinanceParking;
use App\Modules\Explorer\Models\ExplorerTransaction;
use App\Modules\Finance\Models\FinanceAddressBalance;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingFixture
 * @package tests\fixtures\Finance
 */
class FinanceAddressBalanceFixture extends ActiveFixture
{

	use FixtureSupport;

	/**
	 * @var string
	 */
	public $modelClass = FinanceAddressBalance::class;


	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->getFixturesData();
	}

	/**
	 * @return array
	 */
	public static function getDefaultValuesByFields(): array {
		return [
			'id'       => '',
			'address'  => '',
			'balance'  => '',
			'lastSync' => '',
		];
	}

	/**
	 * @return array
	 */
	public function itemAddress(): array {
		return [
			'id'       => 1,
			'address'  => 'XVBcuktbPLr7QqFwBzEySjKFv5ZLwuBHhm',
			'balance'  => 100,
			'lastSync' => '2017-10-13 15:41:44',
		];
	}

	public function itemUser() {
		return [
			'address'  => 'XWtUA1qBvisvnyxKWyBpiRgRwQNX3xiYGS',
			'balance'  => 100,
			'lastSync' => '2017-10-13 15:41:44',
		];
	}

	public function itemSupportUser() {
		return [
			'address'  => 'XVshdGYTzGi8cL6o6hmJ3Hn7w7oNgbqerS2',
			'balance'  => 100,
			'lastSync' => '2017-10-13 15:41:44',
		];
	}

	public function itemAdminUser() {
		return [
			'address'  => 'XVshdGYTzGi8cL6o6hmJ3Hn7w7oNgbqerS3',
			'balance'  => 100,
			'lastSync' => '2017-10-13 15:41:44',
		];
	}


}