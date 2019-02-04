<?php
/**
 * Created by Andru Cherny.
 * User: Tarasenko Andrii
 * Date: 08.11.17
 * Time: 12:32
 */

namespace App\Modules\Explorer\Components;

use App\Helpers\Arr;
use App\Modules\Explorer\Models\ExplorerBlock;
use App\Modules\Explorer\Models\ExplorerInput;
use App\Modules\Explorer\Models\ExplorerOutput;
use App\Modules\Explorer\Models\ExplorerTransaction;
use Yii;
use yii\db\Exception;

trait SaverTrait
{

    /**
     * @param array $blocks
     * @throws Exception
     */
    private function batchSaveBlocks(array $blocks): void {
        $total = count($blocks);

        $inserted = Yii::$app->db->createCommand()->batchInsert(
            ExplorerBlock::tableName(),
            ['hash','height', 'totalAmount', 'fee', 'transactions','createdAt'],
            $blocks
        )->execute();


        if ($inserted !== $total) {
            throw new Exception('Not all transactions saved to DB. inserted: ' . $inserted . ', total: ' . $total);
        }
    }

    /**
     * @param array $transactions
     * @throws Exception
     */
    private function batchSaveTransactions(array $transactions): void {
        $total = count($transactions);

        $transactions = Arr::removeSeveralAssoc($transactions,['inputs', 'outputs']);

        $inserted = Yii::$app->db->createCommand()->batchInsert(
            ExplorerTransaction::tableName(),
            ['hash', 'block', 'amount', 'fee', 'index'],
            $transactions
        )->execute();

        if ($inserted !== $total) {
            throw new Exception('Not all transactions saved to DB. inserted: ' . $inserted . ', total: ' . $total);
        }

    }

    /**
     * @param array $inputs
     * @throws Exception
     */
    private function batchSaveInputs(array $inputs): void {
        $total = count($inputs);

        $inserted = Yii::$app->db->createCommand()->batchInsert(
            ExplorerInput::tableName(),
            ['transactionId', 'amount', 'address',],
            $inputs
        )->execute();

        if ($inserted !== $total) {
            throw new Exception('Not all inputs saved to DB. inserted: ' . $inserted . ', total: ' . $total);
        }
    }

    /**
     * @param array $outputs
     * @throws Exception
     */
    private function batchSaveOutputs(array $outputs): void {
        $total = count($outputs);

        $inserted = Yii::$app->db->createCommand()->batchInsert(
            ExplorerOutput::tableName(),
            ['transactionId', 'amount', 'address',],
            $outputs
        )->execute();

        if ($inserted !== $total) {
            throw new Exception('Not all outputs saved to DB. inserted: ' . $inserted . ', total: ' . $total);
        }
    }

}
