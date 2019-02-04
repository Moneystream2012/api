<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 *
 * Date: 17.10.17
 */
declare(strict_types=1);

namespace tests\fixtures\Explorer;

use App\Modules\Database\FinanceParking;
use App\Modules\Explorer\Models\ExplorerBlock;
use App\Modules\Explorer\Models\ExplorerTransaction;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingFixture
 * @package tests\fixtures\Finance
 */
class ExplorerBlockFixture extends ActiveFixture {

    use FixtureSupport;

    /**
     * @var string
     */
    public $modelClass = ExplorerBlock::class;

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
			'id'           => '',
			'hash'         => '',
			'height'       => '',
			'totalAmount'  => '',
			'fee'          => '',
			'transactions' => '',
			'createdAt'    => '2017-10-24 11:37:15',
		];
	}

	/**
	 * @return array
	 */
	public function itemBlockGenesys():array  {
		return [
			'id' => 1,
			'hash' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0000',
			'height' => 0,
			'totalAmount' => 0,
			'fee' => 0,
			'transactions' => 1,
		];
	}

	/**
	 * @return array
	 */
	public function itemBlockH1():array  {
		return [
			'id' => 2,
			'hash' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0001',
			'height' => 1,
			'totalAmount' => 0.05453563,
			'fee' => 0.00010000,
			'transactions' => 2,
		];
	}

	/**
	 * @return array
	 */
	public function itemBlockH2():array  {
		return [
			'id' => 3,
			'hash' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0002',
			'height' => 2,
			'totalAmount' => 0.05453563,
			'fee' => 0.00010000,
			'transactions' => 4,
		];
	}

	/**
	 * @return array
	 */
	public function itemBlockH3():array  {
		return [
			'id' => 4,
			'hash' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0003',
			'height' => 3,
			'totalAmount' => 0.05453563,
			'fee' => 0.00010000,
			'transactions' => 3,
		];
	}

	/**
	 * @return array
	 */
	public function itemBlockH4():array  {
		return [
			'id' => 5,
			'hash' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0004',
			'height' => 4,
			'totalAmount' => 0.05453563,
			'fee' => 0.00010000,
			'transactions' => 1,
		];
	}
}