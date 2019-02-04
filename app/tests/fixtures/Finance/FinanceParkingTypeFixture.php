<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 21.08.17
 * Time: 11:13
 */
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Database\FinanceParkingType;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingTypeFixture
 * @package 
 */
class FinanceParkingTypeFixture extends ActiveFixture {

	use FixtureSupport;
	
	/**
	 * @var string
	 */
	public $modelClass = FinanceParkingType::class;

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
			'name'   => '',
			'rate'   => '',
			'period' => ''
		];
	}

	/**
	 * @return array
	 */
	public function itemDailyType():array  {
		return [
			'id'     => '1',
			'name'   => 'TestParkingType',
			'rate'   => '0.1',
			'period' => 50000,
		];
	}

	/**
	 * @return array
	 */
	public function itemWeeklyType():array  {
		return [
			'id'     => '2',
			'name'   => 'TestParkingTypeWeekly',
			'rate'   => '0.77',
			'period' => 604800,
		];
	}
}