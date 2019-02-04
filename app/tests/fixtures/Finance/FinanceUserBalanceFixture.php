<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 01.09.17
 * Time: 17:52
 */
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Finance\Models\FinanceAddressBalance;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceTransactionLogFixture.php
 * @package
 */
class FinanceUserBalanceFixture extends ActiveFixture {

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
			'id' => '',
			'address' => '',
			'balance' => '',
			'lastSync' => '',
		];
	}

	/**
	 * @return array
	 */
	public function itemRootUser():array  {
		return [
			'id' => 1,
			'address' => 'XVshdGYTzGi8cL6o6hmJ3Hn7w7oNgbqerS',
			'balance' => 1.00777555,
			'lastSync' => '2017-08-21 09:44:24',
		];
	}

	/**
	 * @return array
	 */
	public function itemSecondUser():array  {
		return [
			'id' => 2,
			'address' => 'qweqweqweqweqweqweqweqweqweqwe_user',
			'balance' => 2,
			'lastSync' => '2017-08-21 09:44:24',
		];
	}
}
