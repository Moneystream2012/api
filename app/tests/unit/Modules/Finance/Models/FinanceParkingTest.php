<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 13.10.17
 */


namespace tests\unit\Modules\Finance\Components;

use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Components\ParkingService;
use App\Modules\Finance\Models\FinanceParking;
use App\Modules\Finance\Models\Query\FinanceParking as FinanceParkingQuery;
use Codeception\Specify;
use Codeception\Test\Unit;
use Codeception\Util\Stub;
use tests\fixtures\Finance\Unit\ExpiredParkingsFixture;
use AspectMock\Test as test;
use tests\fixtures\Finance\Unit\UserAddressesFixture;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class PayoutServiceTest
 * @package tests\unit\Modules\Finance\Components
 */
class FinanceParkingTest extends Unit
{
    use Specify;

    /**
     * @var FinanceParking
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

        $this->tested = FinanceModelFactory::create(FinanceModelFactory::PARKING);
    }

    protected function _after() {
        $this->tested = null;
    }

    public function testFindExpiredParkings() {
        $this->specify('Method findExpiredParkings have to return array of expired parkings', function () {
            $fixture = $this->tester->grabFixture('parkings')['data'];
            $activeQuery = test::double(ActiveQuery::class, [
                'all' => $fixture
            ]);

            $result = $this->tested->findExpiredParkings();

            $activeQuery->verifyInvoked('all');

            $this->assertEquals(count($result), count($fixture));

            foreach ($result as $index => $parking) {
                $this->assertEquals($parking, $fixture[$index]);
            }

        });
    }

    public function testCompleteParkings() {
        $this->specify('Method completeParkings have to change statuses of parkings to complete by given parking ids. return bool',
            function () {
                test::clean(ActiveQuery::class);

                $parkingMock1 = test::double(FinanceModelFactory::getClass(FinanceModelFactory::PARKING), ['save' => true]);
                $parkingMock2 = test::double(FinanceModelFactory::getClass(FinanceModelFactory::PARKING), ['save' => true]);

                $activeQuery = test::double(ActiveQuery::class, [
                    'all' => [$parkingMock1->make(), $parkingMock2->make()]
                ]);

                $this->tested->cancelParkings([1,2]);

                $activeQuery->verifyInvoked('all');
                $parkingMock1->verifyInvoked('save');
                $parkingMock2->verifyInvoked('save');
            }
        );
    }

    public function testGetParkingsByAddresses() {
        $this->specify('Method getParkingsByAddresses have to find active parkings by given addresses and group them by address',
            function () {
                test::clean(ActiveQuery::class);
                test::clean(ActiveQuery::class);

                $addresses = $this->tester->grabFixture('userAddresses')['data'];

                $userId = key($addresses);

                $mockActiveQuery = test::double(ActiveQuery::class, ['all' => [['userId' => $userId, 'address' => $addresses[$userId]]]]);
                $mockParkingQuery = test::double(FinanceParkingQuery::class, ['all' => [
                    ['id' => 1, 'userId' => 1],
                    ['id' => 2, 'userId' => 1]
                ]]);
                $result = $this->tested->getParkingsByAddresses($addresses);

                foreach ($result as $address => $parkings) {
                    $this->assertTrue(in_array($address, $addresses));
                    $this->assertTrue(is_array($parkings));
                    $this->assertTrue(count($parkings) > 0);
                    $this->assertTrue(!empty($parkings[0]['id']));
                }
            }
        );
    }
}