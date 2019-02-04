<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 21.08.17
 * Time: 11:13
 */
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Database\FinanceParking;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingFixture
 * @package tests\fixtures\Finance
 */
class FinanceParkingFixture extends ActiveFixture {

	use FixtureSupport;
	
	/**
	 * @var string
	 */
	public $modelClass = FinanceParking::class;

	/**
	 * @var array
	 */
	public $depends = [FinanceParkingTypeFixture::class];

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
			'id'        => '',
			'userId'    => '',
			'typeId'    => '',
			'amount'    => '',
			'rate'      => '',
			'createdAt' => '2017-08-24 11:37:15',
			'status'    => ''

		];
	}

	/**
	 * @return array
	 */
	public function itemFirstPending(): array {
		return [
			'id'        => 1,
			'userId'    => 1,
			'typeId'    => 1,
			'amount'    => 29.25087515,
			'rate'      => '0.07',
			//'createdAt' => '',
			'status'    => 'pending'
		];
	}

	/**
	 * @return array
	 */
	public function itemUserCompleted(): array {
		return [
			'id'        => 2,
			'userId'    => 2,
			'typeId'    => 1,
			'amount'    => 210.47584999,
			'rate'      => '0.07',
			//'createdAt' => '',
			'status'    => 'completed'
		];
	}

	/**
	 * @return array
	 */
	public function itemUserActive(): array {
		return [
			'id'        => 3,
			'userId'    => 2,
			'typeId'    => 1,
			'amount'    => 77.17584222,
			'rate'      => '0.07',
			//'createdAt' => '',
			'status'    => 'active'
		];
	}

	/**
	 * @return array
	 */
	public function itemUserActive2(): array {
		return [
			'id'        => 4,
			'userId'    => 2,
			'typeId'    => 1,
			'amount'    => 10.00000111,
			'rate'      => '0.08',
			//'createdAt' => '',
			'status'    => 'active'
		];
	}

	/**
	 * @return array
	 */
	public function itemSupportActive(): array {
		return [
			'id'        => 5,
			'userId'    => 3,
			'typeId'    => 1,
			'amount'    => 11.33383555,
			'rate'      => '0.07',
			//'createdAt' => '',
			'status'    => 'active'
		];
	}

	/**
	 * @return array
	 */
	public function itemAdminActive(): array {
		return [
			'id'        => 6,
			'userId'    => 4,
			'typeId'    => 1,
			'amount'    => 12.47583999,
			'rate'      => '0.07',
			//'createdAt' => '',
			'status'    => 'active'
		];
	}

	/**
	 * @return array
	 */
	public function itemAdminPending(): array {
		return [
			'id'        => 7,
			'userId'    => 4,
			'typeId'    => 1,
			'amount'    => 12.47583999,
			'rate'      => '0.07',
			//'createdAt' => '',
			'status'    => 'pending'
		];
	}

	/**
	 * @return array
	 */
	public function itemUserPending(): array {
		return [
			'id'        => 8,
			'userId'    => 2,
			'typeId'    => 1,
			'amount'    => 2.27583777,
			'rate'      => '0.08',
			//'createdAt' => '',
			'status'    => 'pending'
		];
	}

	/**
	 * @return array
	 */
	public function itemUserCanceled(): array {
		return [
			'id'        => 9,
			'userId'    => 2,
			'typeId'    => 1,
			'amount'    => 2.27583777,
			'rate'      => '0.08',
			//'createdAt' => '',
			'status'    => 'canceled'
		];
	}
}