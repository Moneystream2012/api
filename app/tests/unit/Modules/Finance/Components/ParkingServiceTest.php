<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 13.10.17
 */

namespace tests\unit\Modules\Finance\Components;

use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Components\ParkingService;
use App\Modules\Finance\Exceptions\ParkingServiceException;
use Codeception\Specify;
use Codeception\Test\Unit;
use Codeception\Util\Stub;
use tests\fixtures\Finance\Unit\ExpiredParkingsFixture;
use AspectMock\Test as test;
use tests\fixtures\Finance\Unit\UserAddressesFixture;

/**
 * Class PayoutServiceTest
 * @package tests\unit\Modules\Finance\Components
 */
class ParkingServiceTest extends Unit
{
    use Specify;

    /**
     * @var ParkingService
     */
    protected $tested;

    public function _fixtures() {
        return [
            'parkings' => ExpiredParkingsFixture::class,
            'userAddresses' => UserAddressesFixture::class,
        ];
    }

    protected function _before() {
        test::clean(FinanceModelFactory::getClass(FinanceModelFactory::PARKING));

        $model = test::double(FinanceModelFactory::getClass(FinanceModelFactory::PARKING), [
            'findExpiredParkings' => $this->tester->grabFixture('parkings')['data'],
            'getUserAddresses' => $this->tester->grabFixture('userAddresses')['data'],
        ])->make();

        $this->tested = new ParkingService();
        $this->tested->setParkingModel($model);
    }

    protected function _after() {
        $this->tested = null;
    }

    public function testGetExpiredParkings() {

        $this->specify('Method getExpiredParkings returns array of expired parkings:', function () {
            $parkings = $this->tested->getExpiredParkings();

            $this->assertTrue(is_array($parkings));
            $this->assertTrue(count($parkings) > 0);
        });


    }

    public function testGetUserAddresses() {
        $this->specify('Method getUserAddresses returns array of user addresses indexed by its id', function () {
            $addresses = $this->tested->getUserAddresses([]);
            $fixtureAddresses = (array) $this->tester->grabFixture('userAddresses')['data'];

            $this->assertTrue(is_array($addresses));
            $this->assertTrue(count($addresses) > 0);
            $this->assertEquals('testAddress', $fixtureAddresses[1]);
        });
    }

    public function testGetPayoutAmount() {
        $this->specify('Method getPayoutAmount returns calculated amount of parking', function () {
            $parkings = $this->tester->grabFixture('parkings')['data'];

            foreach ($parkings as $parking) {
                $result = $this->tested->getPayoutAmount($parking);
                $check = 0;

                if (!empty($parking['amount']) && !empty($parking['rate'])) {
                    $check = $parking['amount']*$parking['rate']/100;
                }

                $this->assertEquals($result, $check);
            }

        });
    }

    public function testCompleteParkings() {
        $this->specify('Method have to call complete parkings on model and throw Exception if not valid', function () {
            $mockedModel = test::double(FinanceModelFactory::getClass(FinanceModelFactory::PARKING), [
                'completeParkings' => false
            ])->make();

            $this->tested->setParkingModel($mockedModel);

            $this->tested->completeParkings([['id' => 1], ['id' => 2]]);

            $mockedModel->verifyInvoked('completeParkings');

        }, ['throws' => ParkingServiceException::class]);
    }

    public function testCancelParkings() {
        $this->specify('Method have to call cancel parkings on model and throw Exception if not valid', function () {
            $mockModel = test::double(FinanceModelFactory::getClass(FinanceModelFactory::PARKING), [
                'cancelParkings' => false
            ])->make();

            $this->tested->setParkingModel($mockModel);

            $this->tested->cancelParkings([['id' => 1], ['id' => 2]]);

            $mockModel->verifyInvoked('cancelParkings');
        }, ['throws' => ParkingServiceException::class]);
    }

    public function testGetSumOfPayoutAmounts() {
        $this->specify('Method getSumOfPayoutAmounts have to summ amount of several parkings', function () {
            $parkings = $this->tester->grabFixture('parkings')['data'];

            $expectedAmount = $this->_getSumOfParkingAmounts($parkings);

            $testAmount = $this->tested->getSumOfPayoutAmounts($parkings);

            $this->assertEquals($expectedAmount, $testAmount);
        });
    }

    public function testGetParkingsNotInSetAmount() {
        $this->specify('Method getParkingsNotInSetAmount have to return parkings which out of set amount', function () {
            $parkings = $this->tester->grabFixture('parkings')['data'];

            $expectedAmount = $this->_getSumOfParkingAmounts($parkings)/2;

        });
    }

    private function _getParkingAmount(array $parking): float  {
        $result = $parking['amount'] * $parking['rate']/100;

        return (float) number_format($result, 8);
    }

    private function _getSumOfParkingAmounts(array $parkings): float {
        $result = 0;

        foreach ($parkings as $parking) {
            $result += $this->_getParkingAmount($parking);
        }

        return $result;
    }
}