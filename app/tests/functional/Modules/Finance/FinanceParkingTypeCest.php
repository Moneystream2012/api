<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * Date: 08.08.17, 10.10.17
 */
declare(strict_types=1);

namespace tests\functional\Modules\Finance;

use \Codeception\Util\HttpCode;
use tests\_support\RestMultyCest;
use tests\fixtures\{
    User\UserFixture,
    User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
    Finance\FinanceParkingTypeFixture
};


/**
 * Class ParkingCest
 * @package tests\functional\Modules\Finance
 */
class FinanceParkingTypeCest
{
	use RestMultyCest;

	public $url = 'finance/parking/type';

	//
	public function _fixtures(): array
	{
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
            FinanceParkingTypeFixture::class,
		];

	}

    /**
     * @example{"role":"admin", "name": "daily", "rate": "0.07", "period":"86400"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function createSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testCreateSuccess($I, $example);
    }

    /**
     * @example{"role":"admin", "name": "daily", "rate": "0.07", "period":"86400"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function createRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testCreateFail($I, $example, HttpCode::FORBIDDEN);
    }

    /**
     * @example{"role":"admin", "name":""}
     * @example{"role":"admin", "rate":""}
     * @example{"role":"admin", "period":""}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function createEmptyFail(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testCreateFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
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
     * @example{"role":"admin", "expected":[{"id":"1","name":"TestParkingType"}, {"id":"2","name":"TestParkingTypeWeekly"}]}
     * @example{"role":"support", "expected":[{"id":"1","name":"TestParkingType"}, {"id":"2","name":"TestParkingTypeWeekly"}]}
     * @example{"role":"user", "expected":[{"id":"1","name":"TestParkingType"}, {"id":"2","name":"TestParkingTypeWeekly"}]}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getListSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testGetListSuccess($I, $example);
    }

    /**
     * @example{"role":"admin", "id":"1", "send":{"name": "daily", "rate": "0.07", "period":"86400"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testPutSuccess($I, $example);
    }

    /**
     * @example{"role":"admin", "id":"1", "send":{"name": "daily", "rate": "0.07", "period":"86400"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testPutFail($I, $example, HttpCode::FORBIDDEN);
    }

    /**
     * @example{"role":"admin", "id":"1", "send":{"name": ""}}
     * @example{"role":"admin", "id":"1", "send":{"rate": ""}}
     * @example{"role":"admin", "id":"1", "send":{"period": ""}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putEmptyFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testPutFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
    }

    /**
     * @example{"role":"admin", "id":"10", "send":{"name": "", "rate": "0.07", "period":"86400"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putNotFound(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testPutFail($I, $example, HttpCode::NOT_FOUND);
    }

    /**
     * @example{"role":"admin", "id":"1", "expected":{"name": "TestParkingType", "rate": "0.1", "period":"50000"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getByIdRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testGetByIdFail($I, $example, HttpCode::NOT_FOUND);
    }

	/**
	 * @return array
	 */
	protected function createData(): array {
		return [
			"name"   => "daily",
			"rate"   => "0.07",
			"period" => "86400",
		];
	}

	/**
	 * @return array
	 */
	protected function putData(): array {

		return $this->createData();
	}
}