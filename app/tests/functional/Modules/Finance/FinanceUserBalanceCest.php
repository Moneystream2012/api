<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 01.09.17
 * Time: 16:58
 */

namespace tests\functional\Modules\Finance;

use \Codeception\Util\HttpCode;
use tests\_support\RestMultyCest;
use tests\fixtures\{
	User\UserFixture,
	User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
	Finance\FinanceUserBalanceFixture
};

/**
 * Class FinanceUserBalanceCest
 * @package tests\functional\Modules\Finance
 */
class FinanceUserBalanceCest
{
	use RestMultyCest;

	public $url = 'finance/balance';

	//
	public function _fixtures(): array
	{
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
			FinanceUserBalanceFixture::class,
		];
	}

	/**
	 * @example{"role":"admin", "address": "X38s76a867548d767656745w867645775486", "balance":"29.25087515", "lastSync":"2017-10-10 12:37:44"}
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
	 * GET /user
	 */

	/**
	 * @example{"role":"user", "url":"/user", "expected":[{"balance":"0"}]}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function testGetBalance(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testActionPositive($I, $example);
	}

	/**
	 * @example{"role":"user", "allowed":"GET", "url":"/user"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getFilterMethodRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testRestrictedMethods($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"^support", "url": "/user"}
	 * @example{"role":"^admin", "url":"/user"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	/*public function getFilterRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {
		#MOVE
		$this->testActionFail($I, $example, HttpCode::FORBIDDEN);
	}*/
}
