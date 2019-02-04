<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 21.08.17
 * Time: 11:04
 */
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Database\FinanceTransaction;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceTransactionFixture
 * @package tests\fixtures\Finance
 */
class FinanceTransactionFixture extends ActiveFixture {

	use FixtureSupport;
	
	/**
	 * @var string
	 */
	public $modelClass = FinanceTransaction::class;

	/**
	 * @var array
	 */
	public $depends = [FinanceParkingFixture::class];

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
			'hash'      => '',
			'parkingId' => '',
			'amount'    => '',
			'fee'       => '',
			'status'    => '',
			'createdAt' => '',
			'updatedAt' => ''


		];
	}

	/**
	 * @return array
	 */
	public function itemUser2Pending():array  {
		return [
			'id'        => '1',
			'hash'      => 'h123as76543hj6y67y6756yghfvyhyh',
			'parkingId' => '2',
			'amount'    => '10.56745623',
			'fee'       => '0.001',
			'status'    => 'pending',
			'createdAt' => '2017-08-21 09:44:24',
			'updatedAt' => '2017-08-21 10:44:24'
		];
	}

	/**
	 * @return array
	 */
	public function itemUser2Canceled():array  {
		return [
			'id'        => '2',
			'hash'      => 'h435673655476436543hj6y67y6756ygh4876846',
			'parkingId' => '8',
			'amount'    => '77.56745623',
			'fee'       => '0.0015',
			'status'    => 'canceled',
			'createdAt' => '2017-08-21 15:44:44',
			'updatedAt' => '2017-08-21 16:33:14'
		];
	}

	/**
	 * @return array
	 */
	public function itemUser1Pending():array  {
		return [
			'id'        => '3',
			'hash'      => 'h143534643465y67y6756yghfvyhyh',
			'parkingId' => '1',
			'amount'    => '1.56745633',
			'fee'       => '0.001',
			'status'    => 'pending',
			'createdAt' => '2017-08-21 09:44:24',
			'updatedAt' => '2017-08-21 10:44:24'
		];
	}

	/**
	 * @return array
	 */
	public function itemUser4Canceled():array  {
		return [
			'id'        => '4',
			'hash'      => 'h43fdg36536437577543dfg6666756ygh4876846',
			'parkingId' => '7',
			'amount'    => '18.56544663',
			'fee'       => '0.0015',
			'status'    => 'completed',
			'createdAt' => '2017-08-21 15:44:44',
			'updatedAt' => '2017-08-21 16:33:14'
		];
	}
}