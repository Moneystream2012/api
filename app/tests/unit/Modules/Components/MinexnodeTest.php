<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 10.11.17
 * Time: 14:34
 */

namespace tests\unit\Modules\Components;
use App\Components\Rpc;
use AspectMock\Test as test;



class MinexnodeTest extends \Codeception\Test\Unit
{
    public function testNode()
    {
        $rpcMock = test::double(Rpc::class, [
            'getblockhash' => [
                0 => false,
                1 => 500,
                2 => 'Mocked error',
            ],
            'getrawtransaction' => [0 => [100, 200]]
        ]);

        try {
            \Yii::$app->minexnode->getBlockHashByHeight(1);
        } catch (\Exception $e) {}

        $rpcMock->verifyInvokedMultipleTimes('getblockhash', 6);

        \Yii::$app->minexnode->getrawtransaction(1);
        $rpcMock->verifyInvokedMultipleTimes('getrawtransaction', 1);
    }
}
