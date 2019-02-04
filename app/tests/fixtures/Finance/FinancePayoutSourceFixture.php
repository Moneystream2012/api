<?php
/**
 * @author Tarasenko Andrii Demchun <m.demchun@minexsystems.com>
 * Date: 21.08.17
 * Time: 12:16
 */
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Database\FinancePayoutSource;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingFixture
 * @package tests\fixtures\Finance
 */
class FinancePayoutSourceFixture extends ActiveFixture {

	use FixtureSupport;

	/**
	 * @var string
	 */
	public $modelClass = FinancePayoutSource::class;

	/**
	 * @var array
	 */
	public $depends = [];

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
			'address'    => '',
			'createdAt' => '2017-08-24 11:37:15',
		];
	}

	/**
	 * @return array
	 */
	public function itemRootUser():array  {
		return [
			'id'        => 1,
			'address'    => 'XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv',
		];
	}
}
