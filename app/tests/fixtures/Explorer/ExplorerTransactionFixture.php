<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 *
 * Date: 17.10.17
 */
declare(strict_types=1);

namespace tests\fixtures\Explorer;

use App\Modules\Database\FinanceParking;
use App\Modules\Explorer\Models\ExplorerTransaction;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingFixture
 * @package tests\fixtures\Finance
 */
class ExplorerTransactionFixture extends ActiveFixture
{

	use FixtureSupport;

	/**
	 * @var string
	 */
	public $modelClass = ExplorerTransaction::class;

	/**
	 * @var array
	 */
	public $depends = [ExplorerBlockFixture::class];

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
			'id'     => '',
			'hash'   => '',
			'block'  => '',
			'amount' => '',
			'fee'    => '',
			'index'  => '',
		];
	}

	/**
	 * @return array
	 */
	public function itemFirstTransaction(): array {
		return [
			'id'     => 1,
			'hash'   => '5b48d9044881d5dbdfaf96eb56c91f17b843a28492204a3c13a4a3e6982a994a',
			'block'  => '0000004a4f71ed2ef8bbe2fc94437a28d17f1006b7fbfb4ad7f594a87b62d265',
			'amount' => 2.50000000,
			'fee'    => 0,
			'index'  => 0,
		];
	}

	/**
	 * @return array
	 */
	public function itemSecondTransaction(): array {
		return [
			'id'     => 2,
			'hash'   => '64e76dae50284bf219cad8715f0daba11cd42b0f0350423a5cd6b9208e59f04f',
			'block'  => '0000000e5bea4bb21d0916d74ddc31bf700390bdfb713ca7cd76e6107b7d19af',
			'amount' => 2.50000000,
			'fee'    => 0,
			'index'  => 0,
		];
	}
}