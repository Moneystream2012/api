<?php
/**
 * @author Tarasenko Andrii
 * @date: 02.10.17
 */

namespace App\Modules\Explorer\Components;

use App\Components\GlobalConstants;
use App\Components\Math;
use App\Helpers\Arr;
use App\Modules\Explorer\Models\ExplorerBlock;
use App\Modules\Finance\Components\BalanceChange;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceTransaction;
use Yii;
use yii\base\Component;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * Class Synchronizer
 * @package App\Modules\Explorer\Components
 */
class Synchronizer extends Component implements GlobalConstants
{
    use SaverTrait;

    private const LOG_CATEGORY = 'synchronizer';

    private const TX_NONSTANDARD = 'nonstandard';
    private const TX_PUBKEY = 'pubkey';
    private const TX_PUBKEYHASH = 'pubkeyhash';
    private const TX_SCRIPTHASH = 'scripthash';
    private const TX_MULTISIG = 'multisig';
    private const TX_NULL_DATA = 'nulldata';
    private const TX_WITNESS_V0_SCRIPTHASH = 'witness_v0_keyhash';
    private const TX_WITNESS_V0_KEYHASH = 'witness_v0_scripthash';

    /**
     *
     */
    private const ALLOWED_XT_TYPE = [
        self::TX_PUBKEY,
        self::TX_PUBKEYHASH,
        self::TX_SCRIPTHASH,
        self::TX_WITNESS_V0_SCRIPTHASH,
        self::TX_WITNESS_V0_KEYHASH,
        ];

    private const REDIS_PREFIX_TRANSACTION = 'minexnode_';
    private const REDIS_TRANSACTION_TIMEOUT = 300;   // 5 minute

    /**
     * @var int $scale
     */
    private $scale;

    /**
     * @var \App\Components\Minexnode
     */
    private $node;

    /**
     * @var array
     */
    private $dbBestBlock = [];

    /**
     * Init class
     */
    public function init() {

        $this->scale = self::SCALE;
        $this->node = Yii::$app->minexnode;

        $block = $this->getBestBlockFromDb();

        $this->dbBestBlock = empty($block)
            ? $this->addGenesisBlock()
            : $block;
    }

    /**
     * @param string $hash
     * @return array
     */
    public function getNodeBlockByHash(string $hash): ?array {
        return $this->node->getBlock($hash);
    }

    /**
     * @param array $block
     * @return bool
     */
    public function isBestBlock(array $block): bool {


        self::info('isBestBlock => in DB:#' . $this->dbBestBlock['height'] . ' In request:#' . $block['height']);
        return
            (($block['height'] > $this->dbBestBlock['height'])
                || (
                    $block['height'] == $this->dbBestBlock['height']
                    && $block['hash'] == $this->dbBestBlock['hash']
                ));
    }

    /**
     * @return array
     */
    public function findRootInDb(): array {
        $result = [];
        $height = (int) $this->dbBestBlock['height'];

        while ($height >= 0)
        {
            $candidateBlock = ExplorerBlock::getBlockByHeight($height);
            $candidateHash = $this->node->getBlockHashByHeight($height);

            if (isset($candidateBlock['hash']) && ($candidateHash == $candidateBlock['hash']))
            {
                $result = $candidateBlock;
                break;
            }
            $height--;
        }
        return $result;
    }

    /**
     * @param int $height
     * @param int $id
     */
    public function deleteBlocksInDbIfNeed(int $height, int $id): void {
        if ($this->isNeedToDeleteBlocksInDb($height)) {
            $this->deleteBlocksInDb($id);
        }
    }

    /**
     * @param int $startBlockHeight
     * @param int $endBlockHeight
     * @throws Exception
     */
    public function createBlockChain(int $startBlockHeight, int $endBlockHeight): void {
        self::info('Start creating block chain.');

        for($i = $startBlockHeight; $i <= $endBlockHeight; $i++) {
            $dbTransaction = Yii::$app->db->beginTransaction();

            try {

                $blockHash = $this->node->getBlockHashByHeight($i);
                $rawBlock = $this->getNodeBlockByHash($blockHash);

                $this->processBlock($rawBlock);

                $dbTransaction->commit();
                //$dbTransaction->rollBack();

            } catch (Exception $e) {
                $dbTransaction->rollBack();
                throw $e;
            }
        }
    }

    /**
     * Main function to process block by base info
     * @param $rawBlock
     */
    private function processBlock(array $rawBlock): void {
        list($block, $transactions, $inputs, $outputs) = $this->getStructuredDataFromRawBlock($rawBlock);

        $this->batchSaveBlocks([$block]);
        $this->batchSaveTransactions($transactions);
        $this->batchSaveInputs($inputs);
        $this->batchSaveOutputs($outputs);

        $hashes = ArrayHelper::getColumn($transactions, 'hash');
        $this->updatePayoutStatuses($hashes);

        $balanceChanges = $this->formatBalanceChanges($transactions);

        $this->notifyRecountBalance(
            $balanceChanges,
            'direct',
            Yii::$app->formatter->asDatetime($block['createdAt'])
        );
    }

    private function formatBalanceChanges(array $transactions, bool $down = false) {
        //Calculate changes by address
        $changes = [];
        foreach ($transactions as $item) {
            $changeByTransaction = [];
            foreach ($item['inputs'] as $input) {
                if(!isset($changeByTransaction[$input['address']])) {
                    $changeByTransaction[$input['address']] = 0;
                }
                if($down) {
                    $changeByTransaction[$input['address']] = Math::Add($changeByTransaction[$input['address']], $input['amount'], self::SCALE);
                } else {
                    $changeByTransaction[$input['address']] = Math::Sub($changeByTransaction[$input['address']], $input['amount'], self::SCALE);

                }
            }

            foreach ($item['outputs'] as $output) {
                if(!isset($changeByTransaction[$output['address']])) {
                    $changeByTransaction[$output['address']] = 0;
                }
                if($down) {
                    $changeByTransaction[$output['address']] = Math::Sub($changeByTransaction[$output['address']], $output['amount'], self::SCALE);
                } else {
                    $changeByTransaction[$output['address']] = Math::Add($changeByTransaction[$output['address']], $output['amount'], self::SCALE);

                }
            }
            $changes[] = [
                'transactionHash' => $item['hash'],
                'changes' => $changeByTransaction
            ];
        }
        //Reformat output
        $difference = [];
        foreach ($changes as $tChanges) {
            foreach ($tChanges['changes'] as $address => $value) {
                $difference[] = [
                    'address' => $address,
                    'amount' => $value,
                    'transactionId' => $tChanges['transactionHash'],
                ];
            }

        }
        return $difference;

    }

    /**
     * @return array|null
     */
    private function getBestBlockFromDb(): ?array {
        self::info('Get Best Block From DB.');
        return ExplorerBlock::getHighestBlock()->asArray()->one();
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function addGenesisBlock(): array {
        self::info('Add Genesis Block');
        $dbTransaction = Yii::$app->db->beginTransaction();

        try {

            $hash = $this->node->getBlockHashByHeight(0);

            $rawBlock = $this->getNodeBlockByHash($hash);

            $blockData = [
                'hash' => $hash,
                'height' => 0,
                'value' => 0,
                'fee' => 0,
                'tx' => isset($rawBlock['tx']) ? $rawBlock['tx'] : [],
                'time' => isset($rawBlock['time']) ? $rawBlock['time'] : time(),
            ];

            $this->processBlock($blockData);

            $dbTransaction->commit();

        } catch (\Exception $e) {
            $dbTransaction->rollBack();
            throw $e;
        }

        return $blockData;
    }

    /**
     * @param int $height
     * @return bool
     */
    private function isNeedToDeleteBlocksInDb(int $height): bool {
        return $height < (int) $this->dbBestBlock['height'];
    }

    /**
     * @param int $id
     * @throws \yii\db\Exception
     */
    private function deleteBlocksInDb(int $id): void {
        self::info('Start deleting blocks.');

        $blocks = ExplorerBlock::find()
            ->where(['>', 'id', $id])
            ->with(['transactions'])
            ->asArray()
            ->all();

        foreach ($blocks as $block) {
            Yii::trace('Delete block#' . $block['id']);



            if(!ExplorerBlock::deleteAll(['id', $block['id']])) {
                throw new \yii\db\Exception('Error to delete blocks ID:' . $block['id']);
            }

            $balanceChanges = $this->formatBalanceChanges($block['transactions'], true);

            $this->notifyRecountBalance(
                $balanceChanges,
                'rollback',
                Yii::$app->formatter->asDatetime($block['createdAt'])
            );
        }
    }

    private function getStructuredDataFromRawBlock(array $rawBlock): array {

        $block = $this->getBlockDataFromRaw($rawBlock);

        list($transactions, $inputs, $outputs, $totalAmount, $fee) = $this->getTransactionsDataFromRaw($block['hash'], $rawBlock['tx']);

        $block['totalAmount'] = (float)$totalAmount;
        $block['fee'] = (float)$fee;

        return [$block, $transactions, $inputs, $outputs];
    }

    private function getBlockDataFromRaw(array $rawBlock): array {
        return [
            'hash' => $rawBlock['hash'],
            'height' => $rawBlock['height'],
            'totalAmount' => 0,//$transactions['value'],
            'fee' => 0,//$transactions['fee'],
            'transactions' => count($rawBlock['tx']),
            'createdAt' => Yii::$app->formatter->asDatetime($rawBlock['time']),
        ];
    }

    /**
     * @param string $blockHash
     * @param array $transactions
     * @return array
     * @throws ErrorException
     */
    private function getTransactionsDataFromRaw(string $blockHash, array $transactions): array {

        $totalTransactions = [];
        $allInputs = [];
        $allOutputs = [];
        $totalAmount = 0;
        $fee = 0;
        $coinBaseData = [
            'transaction' => [],
            'inputs'      => [],
            'outputs'     => []
        ];

        foreach ($transactions as $index => $transaction) {

            list($inputs, $inputAmount, $coinBaseExist) = $this->getInputsDataFromRaw($transaction['hash'], $transaction['vin']);
            list($outputs, $outputAmount) = $this->getOutputsDataFromRaw($transaction['hash'], $transaction['vout']);

            if ($coinBaseExist) {
                $inputAmount = $outputAmount;
            }

            $trxFee = Math::Sub($inputAmount, $outputAmount, self::SCALE);

            $transactionItem = [
                'hash'    => $transaction['hash'],
                'block'   => $blockHash,
                'amount'  => $outputAmount,
                'fee'     => $trxFee,
                'index'   => $index,
                'inputs'  => $inputs,
                'outputs' => $outputs
            ];

            //If this coinbase, save to another storage
            if ($coinBaseExist) {
                $coinBaseData['transaction'] = $transactionItem;
                $coinBaseData['inputs'] = $inputs;
                $coinBaseData['outputs'] = $outputs;
            } else {
                //Add data to general storage
                $totalTransactions[] = $transactionItem;
                $allInputs = Arr::merge($allInputs, $inputs);
                $allOutputs = Arr::merge($allOutputs, $outputs);
            }

            $totalAmount = Math::Add($totalAmount, $outputAmount, self::SCALE);;
            $fee = Math::Add($fee, $trxFee, self::SCALE);

        }

        //Calculate coin base
        if($coinBaseData['inputs'][0]['address'] == 'coinbase') {

            $coinBaseAmount = Math::Sub($coinBaseData['transaction']['amount'], $fee, self::SCALE);

            $coinBaseData['inputs'][0]['amount'] = $coinBaseAmount;
            $coinBaseData['transaction']['inputs'] = $coinBaseData['inputs'];

            $totalTransactions = Arr::merge([$coinBaseData['transaction']], $totalTransactions);
            $allInputs = Arr::merge($coinBaseData['inputs'], $allInputs);
            $allOutputs = Arr::merge($coinBaseData['outputs'], $allOutputs);

        } else {
            throw new ErrorException('Can not find CoinBase transaction!!!!!!' . $coinBaseData['inputs'][0]['address']);
        }


        return [$totalTransactions, $allInputs, $allOutputs, $totalAmount, $fee];
    }

    /**
     * @param string $trxHash
     * @param array $inputs
     * @return array[] {
     *  @var string $transactionId
     *  @var string $amount
     *  @var string $address
     * }
     */
    private function getInputsDataFromRaw(string $trxHash, array $inputs): array {
        $allInputs = [];
        $inputAmount = 0;
        $coinBaseExist = false;

        foreach ($inputs as $idx => $input)
        {
            if (!empty($input['coinbase'])) {
                $allInputs[] = [
                    'transactionId' => $trxHash,
                    'amount' =>  -1,
                    'address' => 'coinbase',
                ];

                //Set information. This is coinbase transaction
                $coinBaseExist = true;

                break;
            }

            $outTransaction = $this->getRawTransaction($input['txid']);

            if (!isset($outTransaction['vout'][$input['vout']]))
            {
                continue;
            }

            $vout = $outTransaction['vout'][$input['vout']];



            if (in_array($vout['scriptPubKey']['type'], self::ALLOWED_XT_TYPE)) {
                $allInputs[] = [
                    'transactionId' => $trxHash,
                    'amount' => $vout['value'],
                    'address' => Arr::getValue($vout, 'scriptPubKey.addresses.0'),
                ];
            } else {
                Yii::error([
                    'msg' => 'Don\'t handle this input type:'. $vout['scriptPubKey']['type'],
                    'tags' => [
                        'transactionHash' => $trxHash,
                        'outputNumber'    => $vout['n'],
                    ]
                ]);
            }

            $inputAmount = Math::Add($inputAmount, $vout['value'], self::SCALE);
        }

        return [$allInputs, $inputAmount, $coinBaseExist];
    }

    private function getOutputsDataFromRaw(string $trxHash, array $outputs): array {
        $allOutputs = [];
        $outputAmount = 0;

        foreach ($outputs as $output) {
            if (in_array($output['scriptPubKey']['type'], self::ALLOWED_XT_TYPE)) {
                $allOutputs[] = [
                    'transactionId' => $trxHash,
                    'amount' => $output['value'],
                    'address' => Arr::getValue($output, 'scriptPubKey.addresses.0'),
                ];
            } else {
                Yii::error([
                    'msg' => 'Don\'t handle this output type:'. $output['scriptPubKey']['type'],
                    'tags' => [
                        'transactionHash' => $trxHash,
                        'outputNumber'    => $output['n'],
                    ]
                ]);
            }

            $outputAmount = Math::Add($outputAmount, $output['value'], self::SCALE);
        }

        return [$allOutputs, $outputAmount];
    }

    private function notifyRecountBalance(array $balanceChanges, string $status, string $transactionsTime): void {

        $changes = [];


        foreach ($balanceChanges as $change)
        {
            $address = $change['address'];

            if (empty($changes[$address])) {
                $changes[$address] = [
                    'address' => $address,
                    'balance' => 0,
                    'status' => $status,
                    'lastSync' => Yii::$app->formatter->asDatetime(time(), \App\Components\BaseModel::DB_DATE_TIME_FORMAT),
                    'lastSyncMicrotime' => microtime(true)
                ];
            }

            $changes[$address]['balance'] = Math::Add($changes[$address]['balance'], $change['amount'], 8);

            $changes[$address]['transactions'][] = [
                'transactionId' => $change['transactionId'],
                'amount' => $change['amount']
            ];
        }

        if (!empty($changes))
        {
            self::info('Balance change for addresses: ');
            self::info(array_keys($changes));
            $balanceChange = new BalanceChange();
            $balanceChange->transactionsTime = $transactionsTime;
            $balanceChange->proceed($changes);
        }
    }

    private static function info($message): void {
        Yii::info($message, self::LOG_CATEGORY);
    }

    /**
     * @param array $hashes
     * @throws Exception
     */
    private function updatePayoutStatuses(array $hashes): void {
        /* @var FinanceTransaction $modelClass */
        $modelClass = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        $savedCount = $modelClass::updateAll(['status' => $modelClass::TYPE_COMPLETED], ['hash' => $hashes]);

        if ($savedCount != 0) {
            Yii::info("Update status of " . $savedCount . ' transaction(s)');
        }
    }

    /**
     * @param string $hash
     *
     * @return array
     */
    private function getRawTransaction(string $hash): array {

        $key = static::REDIS_PREFIX_TRANSACTION . $hash;

        if (!Yii::$app->redis->exists($key)) {
            $record = $this->node->getRawTransaction($hash);

            if (!empty($record)) {
                Yii::$app->redis->set($key, json_encode($record));
                Yii::$app->redis->expire($key, static::REDIS_TRANSACTION_TIMEOUT);

            } else {
                $record = [];
            }

        } else {
            $record = json_decode(Yii::$app->redis->get($key), true);
        }

        return $record;
    }
}
