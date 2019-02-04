<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * Date: 08.08.17, 09.10.17
 */
declare(strict_types=1);

namespace tests\functional\Modules\Finance;

use \Codeception\Util\HttpCode;
use tests\_support\RestMultyCest;
use tests\fixtures\{
    User\UserFixture,
    User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
    Finance\FinancePayoutSourceFixture
};

/**
 * Class ParkingCest
 * @package tests\functional\Modules\Finance
 */
class FinancePayoutSourceCest
{
	use RestMultyCest;

	public $url = 'finance/payout/source';

	//
	public function _fixtures(): array {
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
			FinancePayoutSourceFixture::class,
		];

	}

    /**
     * @example{"role":"admin", "address":"XXZt9nLj9vi3YWcUGUSq1Qng5GWYxS1Go2"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function createSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateSuccess($I, $example);
	}

    /**
     * @example{"role":"admin", "address":"XXZt9nLj9vi3YWcUGUSq1Qng5GWYxS1Go2"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function createDoubleFail(\FunctionalTester $I, \Codeception\Example $example): void {

        //$this->testCreateSuccess($I, $example);

	    //#UNSTABLE_TEST $this->testCreateFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
    }

    /**
     * @example{"role":"admin", "address":"XXZt9nLj9vi3YWcUGUSq1Qng5GWYxS1Go2"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function createRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		//#UNSTABLE_TEST $this->testCreateFail($I, $example, HttpCode::FORBIDDEN);
	}

    /**
     * @example{"role":"admin", "address":""}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function createAddressEmptyFail(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testCreateFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
	}

    /**
     * @example{"role":"admin", "id":"1"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function deleteSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testDeleteSuccess($I, $example);
	}

    /**
     * @example{"role":"admin", "id":"1"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function deleteRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testDeleteFail($I, $example, HttpCode::FORBIDDEN);
    }

    /**
     * @example{"role":"admin", "id":"10"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function deleteNoExists(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testDeleteFail($I, $example, HttpCode::NOT_FOUND);
    }

    /**
     * @example{"role":"admin", "expected":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getListSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testGetListSuccess($I, $example);
	}

    /**
     * @example{"role":"admin"}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getListRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testGetListFail($I, $example, HttpCode::FORBIDDEN);
    }

    /**
     * @example{"role":"admin", "id":"1", "send":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testPutSuccess($I, $example);
	}

    /**
     * @example{"role":"admin", "id":"1", "send":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testPutFail($I, $example, HttpCode::FORBIDDEN);
    }

    /**
     * @example{"role":"admin", "id":"1", "send":{"address":""}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putAddressEmptyFail(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testPutFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
    }

    /**
     * @example{"role":"admin", "id":"10", "send":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function putNotFound(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testPutFail($I, $example, HttpCode::NOT_FOUND);
    }

    /**
     * @example{"role":"admin", "id":"1", "expected":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getByIdPositive(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testGetByIdSuccess($I, $example);
    }

    /**
     * @example{"role":"admin", "id":"1", "send":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getByIdRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	    //#UNSTABLE_TEST $this->testGetByIdFail($I, $example, HttpCode::FORBIDDEN);
    }

    /**
     * @example{"role":"admin", "id":"10", "send":{"address":"XBSycTHroPADE8U5EGzYwAD2XEpsxYUpxv","createdAt":"2017-08-24 11:37:15"}}
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    public function getByIdNotFoundFail(\FunctionalTester $I, \Codeception\Example $example): void {

        $this->testGetByIdFail($I, $example, HttpCode::NOT_FOUND);
    }
}