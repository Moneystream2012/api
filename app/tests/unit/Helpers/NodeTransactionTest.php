<?php
/**
 * @author Tarasenko Andrii
 * @date: 16.10.17
 */

namespace tests\unit\Helpers;

use App\Components\Rpc;
use App\Exceptions\NodeTransactionException;
use App\Helpers\NodeTransaction;
use Codeception\Specify;
use Codeception\Test\Unit;
use AspectMock\Test as test;
use tests\fixtures\Finance\Unit\UnspentInputsFixture;

/**
 * Class NodeTransactionTest
 * @package tests\unit\Helpers
 */
class NodeTransactionTest extends Unit
{
    use Specify;

    /**
     * @var NodeTransaction
     */
    protected $tested;

    protected function _before() {
        test::clean(Rpc::class);
        $this->tested = new NodeTransaction(['addressForChange' => 'addressForChange']);
    }

    protected function _after() {
       $this->tested = null;
       test::clean(Rpc::class);
    }

    public function _fixtures() {
        return [
            'unspentInputs' => UnspentInputsFixture::class
        ];
    }

    public function testGetUnspentInputs() {
        $this->specify('Method getUnspent have to return unspent inputs for set amount', function () {
            $fixtureInputs = $this->tester->grabFixture('unspentInputs')['data'];

            $mockedRpc = test::double(Rpc::class, [
                'listunspent' => [$fixtureInputs]
            ]);

            $amount = array_sum(
                array_map(
                    function($item){
                        return $item['amount'];
                    },
                    $fixtureInputs
                )
            );

            $result = $this->tested->getUnspentInputs($amount - $this->tested->fee);

            usort($fixtureInputs, function ($a, $b) {
                return $a['amount'] == $b['amount']
                    ? 0
                    : $a['amount'] < $b ['amount']
                        ? -1
                        : 1;
            });

            $this->assertTrue(is_array($result));
            $this->assertTrue(count($result) > 0);
            $this->assertEquals($result[0], $fixtureInputs[0]);
        });
    }

    public function testSignRawTransaction() {
        $this->specify('Method signRawTransaction have to return valid signed raw transaction response', function (){
            $mockedRpc = test::double(Rpc::class, [
                'signrawtransaction' => function() {return [['hex' => 'testHex', 'complete' => true]];}
            ]);

            $result = $this->tested->signRawTransaction('testHex');

            $mockedRpc->verifyInvoked('signrawtransaction');

            $this->assertTrue(is_array($result));
            $this->assertTrue(key_exists('hex', $result));
            $this->assertTrue(key_exists('complete', $result));
        });
    }

    public function testCreateRawTransaction() {
        $inputs = [
            [ 'txid' => 1, 'vout' => 0.01 ],
            [ 'txid' => 2, 'vout' => 0.02 ],
            [ 'txid' => 3, 'vout' => 0.03 ],
        ];

        $outputs = [1,2,3,4,5];

        $this->specify('Method createRawTransaction have to create raw transaction from inputs and outputs', function () use($inputs, $outputs) {

            $mockedRpc = test::double(Rpc::class, [
                'createrawtransaction' => ['transaction hex']
            ]);

            $result = $this->tested->createRawTransaction($inputs, $outputs);

            $mockedRpc->verifyInvoked('createrawtransaction');
        });
    }

    public function testPrepareTransaction() {
        $outputs = [1,1,1];
        $inputs = [1,2,3];

        $this->specify('Method prepareTransaction prepares transaction for block-chain and call several methods of tested class',
            function () use($inputs, $outputs) {

                $sign = ['signed'];

                $mockedTested = test::double(NodeTransaction::class, [
                    'createRawTransaction' => 'someHex123',
                    'signRawTransaction' => $sign
                ]);

                $result = $this->tested->prepareTransaction($inputs, $outputs);

                $mockedTested->verifyInvoked('createRawTransaction');
                $mockedTested->verifyInvoked('signRawTransaction');
                $this->assertEquals($result, $sign);

                test::clean(NodeTransaction::class);
            });
    }

    public function testSendRawTransaction() {
        $this->specify('Method sendRawTransaction have to return transaction hash', function () {
            test::clean(Rpc::class);
            $mokedRPC = test::double(Rpc::class, [
                'sendrawtransaction' => ['someHash']
            ]);

            $result = $this->tested->sendRawTransaction('someHex');

            $mokedRPC->verifyInvoked('sendrawtransaction');
            $this->assertEquals($result, 'someHash');
        });

        $this->specify('Method sendrawtransaction have to return null', function () {
            test::clean(Rpc::class);
            $mokedRPC = test::double(Rpc::class, [
                'sendrawtransaction' => [true]
            ]);

            $result = $this->tested->sendRawTransaction('someHex');

            $mokedRPC->verifyInvoked('sendrawtransaction');
            $this->assertEquals($result, null);
        });
    }
}
