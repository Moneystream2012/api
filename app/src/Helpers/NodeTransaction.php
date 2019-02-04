<?php
/**
 * @author Tarasenko Andrii
 * @date: 16.10.17
 */

declare(strict_types=1);

namespace App\Helpers;

use Yii;
use yii\base\Object;
use yii\helpers\Json;
use App\Components\Minexnode;
use App\Exceptions\NodeTransactionException;

/**
 * Encapsulate minex node raw transaction logic
 * Class NodeTransaction
 * @package App\Helpers
 */
class NodeTransaction extends Object
{
    private const LOG_CATEGORY = 'nodeTransaction';

    /**
     * @var float
     */
    public $fee = 0.00001;

    /**
     * @var string
     */
    public $addressForChange;

    /**
     * @var Minexnode
     */
    private $node;

    public function init() {
        $this->node = \Yii::$app->localMinexnode;
    }

    /**
     * @param float $fee
     */
    public function setTransactionFee(float $fee): void {
        $this->fee = $fee;
    }

    /**
     * @param array $inputs
     * @param array $outputs
     * @return array
     * @throws NodeTransactionException
     */
    public function prepareTransaction(array $inputs, array $outputs): array {

        $hex = $this->createRawTransaction($inputs, $outputs);

        if (preg_match("/[^A-Za-z0-9]/", $hex)) {
            throw new NodeTransactionException("Transaction hex don't match pattern.");
        }

        return $this->signRawTransaction($hex);
    }

    /**
     * Get unspent for new transaction.
     *
     * @param double $amount
     *
     * @return array
     */
    public function getUnspentInputs(float $amount): array
    {
        $amount -= $this->fee;
        $result = [];
        $availableIns = $this->node->listUnspent();

        if (!empty($availableIns))
        {
            // sort TX_inputs by increase, for spent first less amount inputs
            usort(
                $availableIns,
                function($input1,$input2)
                {
                    if ($input1['amount'] == $input2['amount'])
                    {
                        return 0;
                    }
                    return ($input1['amount'] < $input2['amount']) ? -1 : 1;
                });

            foreach ($availableIns as $input)
            {
                $result[] = $input;
                $amount -= $input['amount'];

                if ($amount <= 0) { // if we find enough amount in inputs we break
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Create Raw Transaction
     * @param array $inputs
     * @param array $outputs Send to
     *
     * @return string
     */
    public function createRawTransaction(array $inputs, array $outputs): string
    {
        $formattedInputs = []; // Inputs

        foreach ($inputs as $input)
        {
            if (!empty($input['txid']) && isset($input['vout']) && $input['vout'] >= 0) {
                $formattedInputs[] = [
                    'txid' => $input['txid'],
                    'vout' => $input['vout'],
                ];
            } else Yii::warning('Not valid input: ' . Json::encode($input), self::LOG_CATEGORY);
        }

        Yii::info('Found inputs', self::LOG_CATEGORY);
        Yii::info($formattedInputs, self::LOG_CATEGORY);

        return $this->node->createrawtransaction($formattedInputs, $outputs);
    }

    /**
     * @param string $hex
     * @return array
     * @throws NodeTransactionException
     */
    public function signRawTransaction(string $hex): array
    {
        $response = $this->node->signRawTransaction($hex);

        Yii::info('Response from transaction:', self::LOG_CATEGORY);
        Yii::info($response, self::LOG_CATEGORY);

        if (!is_array($response)) {
            throw new NodeTransactionException('Response is not array');
        }

        if (!isset($response['hex']) || !isset($response['complete']))
            throw new NodeTransactionException('Wrong response array');

        if ($response['complete'] == false)
            throw new NodeTransactionException('Transaction is not completed');

        return $response;
    }

    /**
     * @param string $hex
     * @return string
     */
    public function sendRawTransaction(string $hex): ?string {
        $result = $this->node->sendRawTransaction($hex);

        return is_string($result) ? $result : null;
    }
}
