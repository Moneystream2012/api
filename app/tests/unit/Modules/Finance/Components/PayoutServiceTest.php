<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 13.10.17
 */


namespace tests\unit\Modules\Finance\Components;

use App\Helpers\NodeTransaction;
use App\Modules\Finance\Components\PayoutService;
use Codeception\Specify;
use tests\unit\BaseTestCase;
use AspectMock\Test as test;

/**
 * Class PayoutServiceTest
 * @package tests\unit\Modules\Finance\Components
 */
class PayoutServiceTest extends BaseTestCase
{
    use Specify;

    /**
     * @var PayoutService
     */
    protected $tested;

    protected function _before()
    {
        test::clean(NodeTransaction::class);
        $this->tested = new PayoutService();
    }

    protected function _after()
    {
        $this->tested = null;
    }

    public function testAddAddressForChangeToOutputsIfNeed() {
        $addressForChange = 'testAddress';
        $totalAmount = 5;
        $this->tested->addressForChange = $addressForChange;
        $this->tested->transactionFee = 0.0001;

        $this->specify('Method addAddressForChangeIfNeed not add address for change', function () use($addressForChange, $totalAmount) {

            $outputs = [1,1,1,1,0.9999]; // total 4.9999

            $resultWithNoAddress = $this->tested->addAddressForChangeToOutputsIfNeed($outputs, $totalAmount);

            $this->assertEquals($outputs, $resultWithNoAddress);
        });

        $this->specify('Method addAddressForChangeIfNeed add address for change', function () use($addressForChange, $totalAmount) {

            $outputs = [1,1,1,0.9999]; // total 3.9999

            $resultWithAddress = $this->tested->addAddressForChangeToOutputsIfNeed($outputs, $totalAmount);

            $this->assertNotEquals($outputs, $resultWithAddress);
            $this->assertTrue(key_exists($addressForChange, $resultWithAddress));
        });
    }

    public function testSendPayoutTransactions() {
        $this->specify('Method sendPayoutTransaction have to send transaction in block-chain and return hash of transaction', function () {
            $payouts = [1,2,3];

            $mockedNodTransaction = test::double(NodeTransaction::class, [
                'getUnspentInputs' => [1,2,3,4],
                'prepareTransaction' => ['complete' => true, 'hex' => 'testHex'],
                'sendRawTransaction' => 'testHash'
            ]);

            $testedMock = test::double(PayoutService::class, [
                'addAddressForChangeToOutputsIfNeed' => $payouts
            ]);

            $result = $this->tested->sendPayoutTransaction($payouts);

            $mockedNodTransaction->verifyInvoked('getUnspentInputs');
            $mockedNodTransaction->verifyInvoked('prepareTransaction');
            $mockedNodTransaction->verifyInvoked('sendRawTransaction');

            $testedMock->verifyInvoked('addAddressForChangeToOutputsIfNeed');

            $this->assertTrue(is_string($result));
            $this->assertEquals($result, 'testHash');
        });

    }

    public function testSaveTransactionWithLog() {

    }

    public function testSaveTransactionToDb() {

    }

    public function testSaveTransactionLog() {

    }
}