<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * Date: 08.08.17
 * Time: 16:27
 */
declare(strict_types=1);

namespace tests\functional\Modules\Finance;

use App\Modules\Finance\Models\FinanceParking;
use AspectMock\Test;
use Codeception\Util\HttpCode;
use tests\_support\AuthCest;
use tests\_support\AuthCestInterface;
use tests\_support\RestMultyCest;
use tests\fixtures\{
	Finance\FinanceAddressBalanceFixture,
	Finance\FinanceParkingFixture,
	User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
	User\UserFixture
};

/**
 * Class ParkingCest
 * @package tests\functional\Modules\Finance
 */
class FinanceParkingCest implements AuthCestInterface
{
	use AuthCest;

	/**
	 * @var string
	 */
	public $url = 'finance/parking';

	//

	/**
	 * @return array
	 */
	public function _fixtures(): array {
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
			FinanceParkingFixture::class,
			FinanceAddressBalanceFixture::class
		];
	}

	/**
	 * @example{"role":"admin", "data":{"userId": 4, "typeId":"1", "amount":"1.2", "rate":"0.1", "status": "completed"}}
	 * @example{"role":"user", "data":{"userId": 2, "typeId":"1", "amount":"1.25", "rate":"0.1", "status": "active"}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 * @throws \Exception
	 */
	public function createSuccess(\FunctionalTester $I, \Codeception\Example $example): void {
		Test::double(FinanceParking::class, ['validateAmount' => null]);

		$this->setUserByRole($example['role']);
		$I->sendPOSTInternal($this->url, $example['data']);
		$I->canSeeResponseIsJson();
		$I->canSeeResponseCodeIs(HttpCode::OK);
		$I->canSeeResponseContainsJson($example['data']);

		Test::clean();
		//$this->testCreateSuccess($I, $example);
	}

	/**
	 * @example{"role":"admin", "data":{"userId": 1, "typeId":"1", "amount":"1111", "rate":"0.07", "status": "active"}}
	 * @example{"role":"admin", "data":{"userId": 1, "typeId":"**", "amount":"1", "rate":"0.07", "status": "active"}}
	 * @example{"role":"admin", "data":{"userId": 1, "typeId":"1", "amount":"***", "rate":"0.07", "status": "active"}}
	 * @example{"role":"admin", "data":{"userId": 1, "typeId":"1", "amount":"1", "rate":"***", "status": "active"}}
	 * @example{"role":"admin", "data":{"userId": 1, "typeId":"1", "amount":"1", "rate":"0.07", "status": "asdf"}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createFail(\FunctionalTester $I, \Codeception\Example $example): void {
		$this->setUserByRole($example['role']);
		$I->sendPOSTInternal($this->url, $example['data']);
		$I->canSeeResponseIsJson();
		$I->canSeeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
	}

	/**
	 * @example{"role":"user", "balance":"89.45168110"}
	 * @example{"role":"admin", "balance":"24.95167998"}
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function balanceSuccess(\FunctionalTester $I,  \Codeception\Example $example): void {
		$this->setUserByRole($example['role']);
		$I->sendGETInternal($this->url.'/balance', []);
		$I->canSeeResponseContainsJson([
			'balance' => $example['balance']
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function balanceFail(\FunctionalTester $I) {
		$I->comment('Login Required');
		/*$I->sendGETInternal($this->url.'/balance');
		$I->canSeeResponseContainsJson(['balance' => 0]);*/
	}


	/**
	 * @exampl{"role":"user", "status":"active"}
	 * @exampl{"role":"support", "balance":"active,pending"}
	 * @exampl{"role":"admin", "balance":"24.95167998"}
	 * @param \FunctionalTester $I
	 */
	public function statusSuccess(\FunctionalTester $I): void {
		$this->setUserByRole('user');
		$I->sendGETInternal($this->url.'/status/active', []);
		$I->canSeeResponseContainsJson([
			'id' => 3,
			'userId' => 2,
			'amount' => 77.17584222,
			'rate' => 0.07,
			'status' => 'active',
			'createdAt' => '2017-08-24 11:37:15',
			'type' => [
				'id'     => 1,
				'name'   => 'TestParkingType',
				'rate'   => 0.1,
				'period' => 50000
			],
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function statusFail(\FunctionalTester $I) {
		$I->comment('Login Required');
		/*$I->sendGETInternal($this->url.'/status/');
		$I->canSeeResponseContainsJson();
		$I->seeResponseCodeIs(HttpCode::OK);*/
	}


	/**
	 * @param \FunctionalTester $I
	 */
	public function adminStatusSuccess(\FunctionalTester $I) {
		$this->setUserByRole('admin');
		$I->sendGETInternal($this->url.'/admin-status/active');
		$I->canSeeResponseContainsJson([
			'id' => 3,
			'userId' => 2,
			'amount' => 77.17584222,
			'rate' => 0.07,
			'status' => 'active',
			'createdAt' => '2017-08-24 11:37:15',
			'type' => [
				'id'     => 1,
				'name'   => 'TestParkingType',
				'rate'   => 0.1,
				'period' => 50000
			],
		]);
	}


	/**
	 * @param \FunctionalTester $I
	 */
	public function adminStatusFail(\FunctionalTester $I) {
		$this->setUserByRole('support');
		$I->sendGETInternal($this->url.'/admin-status/****');
		$I->canSeeResponseContainsJson();
	}


	/**
	 * @param \FunctionalTester $I
	 */
	public function totalCountSuccess(\FunctionalTester $I) {
		$I->am('admin');
		$I->sendGETInternal($this->url.'/total-count');
		$I->canSeeResponseContainsJson([
			'pending'   => 1,
			'active'    => 1,
			'canceled'  => 0,
			'completed' => 0,
			'history'   => 2
			,
		]);
	}


	/**
	 * @param \FunctionalTester $I
	 */
	public function totalCountFail(\FunctionalTester $I) {
		$I->comment('Not need this');
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function adminCountSuccess(\FunctionalTester $I) {
		$I->am('admin');
		$I->sendGETInternal($this->url.'/admin-count');
		$I->canSeeResponseContainsJson([
			'pending'   => 3,
			'active'    => 4,
			'canceled'  => 1,
			'completed' => 1,
			'history'   => 9,
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function adminCountFail(\FunctionalTester $I) {
		$I->comment('Not need this');
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function cancelSuccess(\FunctionalTester $I) {
		$I->am('admin');
		$I->sendPOSTInternal($this->url.'/cancel', ['id' => 1]);
		$I->canSeeResponseContainsJson([
			'success' => true,
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function cancelFail(\FunctionalTester $I) {
		$I->am('admin');
		$I->sendPOSTInternal($this->url.'/cancel', ['id' => 0]);
		$I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->canSeeResponseContainsJson([
			'name' => 'Bad Request',
			'message' => 'Id of parking not set.'
		]);

		$I->am('admin');
		$I->sendPOSTInternal($this->url.'/cancel', ['id' => -10]);
		$I->canSeeResponseContainsJson([
			'name'    => 'Not Found',
			'message' => 'Parking not found',
		]);


	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function activateSuccess(\FunctionalTester $I) {
		$I->sendPOSTInternal($this->url . '/activate', ['id' => 9]);
		$I->seeResponseCodeIs(HttpCode::OK);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function activateFail(\FunctionalTester $I) {
		$I->sendPOSTInternal($this->url . '/activate', ['id' => 1]);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
		$I->canSeeResponseContainsJson([
			'name'    => 'Not Found',
			'message' => 'Parking not found',
		]);

		$I->sendPOSTInternal($this->url . '/activate', ['id' => 0]);
		$I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->canSeeResponseContainsJson([
			'name' => 'Bad Request',
			'message' => 'Id of parking not set.'
		]);


	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function statisticSuccess(\FunctionalTester $I) {
		$I->am('admin');
		$I->sendGETInternal($this->url . '/statistic');
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->canSeeResponseContainsJson([
			'name'    => 'TestParkingType',
			'period' => '50000',
			'balance' => '154.98807178',
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function statisticFail(\FunctionalTester $I) {
		$I->comment('Not need this');
	}
}