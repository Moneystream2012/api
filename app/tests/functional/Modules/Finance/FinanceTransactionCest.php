<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 08.08.17
 * Time: 16:27
 */
declare(strict_types=1);

namespace tests\functional\Modules\Finance;

use \Codeception\Util\HttpCode;
use tests\_support\RestMultyCest;
use tests\fixtures\{
	User\UserFixture,
	User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
	Finance\FinanceTransactionFixture
};

/**
 * Class TransactionCest
 * @package tests\functional\Modules\Finance
 */
class FinanceTransactionCest
{
	use RestMultyCest;

	public $url = 'finance/transaction';

	//
	public function _fixtures(): array
	{
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
			FinanceTransactionFixture::class,
		];

	}

	/**
	 * @example{"role":"admin", "hash": "1238s76a867548d767656745w867645775486", "parkingId":"1", "amount":"29.25087515", "fee":"0.00035", "status":"pending", "createdAt":"2017-10-10 12:37:44", "updatedAt":"2017-10-10 13:47:44"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateFail($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin", "id":"1"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function deleteRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testDeleteFail($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getListRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testGetListFail($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin", "id":"1", "send":{}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function putRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testPutFail($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin", "id":"1"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getByIdRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testGetByIdFail($I, $example, HttpCode::NOT_FOUND);
	}

	//protected function createData() *** RESTRICTED
	//protected function putData() *** RESTRICTED

	/**
	 * GET /status
	 */

	/**
	 * @example{"role":"user", "url":"/status/pending", "expected":[{"id":1, "hash":"h123as76543hj6y67y6756yghfvyhyh", "parkingId":2}]}
	 * @example{"role":"user", "url":"/status/canceled", "expected":[{"id":2, "hash":"h435673655476436543hj6y67y6756ygh4876846", "parkingId":8}]}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function testGetFilter(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testActionPositive($I, $example);
	}

	/**
	 * @example{"role":"user", "allowed":"GET", "url":"/status/pending"}
	 * @example{"role":"user", "allowed":"GET", "url":"/status/canceled"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getFilterMethodRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testRestrictedMethods($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"^support", "url": "/status/pending"}
	 * @example{"role":"^admin", "url":"/status/canceled"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getFilterRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		//#UNSTABLE_TEST $this->testActionFail($I, $example, HttpCode::FORBIDDEN);
	}


	/**
	 * GET /admin-status
	 */

	/**
	 * @example{"role":"admin", "url":"/admin-status/pending", "expected":[{"id":1, "status":"pending", "hash":"h123as76543hj6y67y6756yghfvyhyh", "parkingId":2}, {"id":3, "status":"pending", "hash":"h143534643465y67y6756yghfvyhyh", "parkingId":1}]}
	 * @example{"role":"admin", "url":"/admin-status/canceled", "expected":[{"id":2, "status":"canceled", "hash":"h435673655476436543hj6y67y6756ygh4876846", "parkingId":8}]}
	 * @example{"role":"admin", "url":"/admin-status/completed", "expected":[{"id":4, "status":"completed", "hash":"h43fdg36536437577543dfg6666756ygh4876846", "parkingId":7}]}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function testGetAdminFilter(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testActionPositive($I, $example);
	}

	/**
	 * @example{"role":"admin", "allowed":"GET", "url":"/admin-status/pending"}
	 * @example{"role":"admin", "allowed":"GET", "url":"/admin-status/canceled"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getAdminFilterMethodRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testRestrictedMethods($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin", "url": "/admin-status/pending"}
	 * @example{"role":"admin", "url":"/admin-status/canceled"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getAdminFilterRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		//#UNSTABLE_TEST $this->testActionFail($I, $example, HttpCode::FORBIDDEN);
	}
}