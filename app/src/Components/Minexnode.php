<?php
/**
 * Component for work with minexcoin node.
 *
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date 02.08.17
 */

namespace App\Components;

use Yii;
use Exception;
use yii\base\Component;

/**
 * Class Minexnode
 * @package App\Components
 */
class Minexnode extends Component
{

    /**
     * @var Rpc
     */
    protected $rpc;

    protected $revokeIterationCount = 1;

    const REVOKE_COUNT = 5;

    /**
     * Decode raw transaction.
     *
     * @param string $hex
     * @return array
     */
    public function decodeRawTransaction(string $hex): array {
        return $this->handleRPC(function () use($hex) {
            return $this->getServer()->decoderawtransaction($hex);
        });
    }

    /**
     * Verify message for wallet user verification.
     *
     * @param $address
     * @param $signature
     * @param $message
     * @return bool
     */
    public function verifyMessage($address, $signature, $message): bool {
        return $this->handleRPC(function () use ($address, $signature, $message) {
            return $this->getServer()->verifymessage($address, $signature, $message);
        }) == true;
    }

    /**
     * @return array
     */
    public function getinfo(): array {
        return $this->handleRPC(function () {
            return $this->getServer()->getinfo();
        });
    }

    /**
     * @param string $hashBlock
     * @param int $verbosity
     * @return array|null
     */
    public function getBlock(string $hashBlock, int $verbosity = 2): ?array {
        return $this->handleRPC(function () use ($hashBlock, $verbosity) {
            return $this->getServer()->getblock($hashBlock, $verbosity);
        });
    }

    /**
     * @param int $height
     * @return string
     */
    public function getBlockHashByHeight(int $height): string {
        return $this->handleRPC(function () use($height)  {
            return $this->getServer()->getblockhash($height);
        });
    }

    /**
     * @param string $transactionId
     * @return array
     */
    public function getRawTransaction(string $transactionId): array {
        return $this->handleRPC(function () use($transactionId) {
            return $this->getServer()->getrawtransaction($transactionId, true);
        });
    }

    /**
     * @param array $inputs
     * @param array $outputs
     * @return string
     */
    public function createRawTransaction(array $inputs, array $outputs): string {
        return $this->handleRPC( function () use ($inputs, $outputs) {
            return $this->getServer()->createrawtransaction($inputs, $outputs);
        });
    }

    /**
     * @param string $hex
     * @return array
     */
    public function signRawTransaction(string $hex): array {
        return $this->handleRPC( function () use ($hex) {
            return $this->getServer()->signrawtransaction($hex);
        });
    }

    /**
     * @param string $hex
     * @return string
     */
    public function sendRawTransaction(string $hex): ?string {
        return $this->handleRPC(function () use($hex) {
            return $this->getServer()->sendrawtransaction($hex);
        });
    }

    /**
     * @return array|null
     */
    public function listUnspent(): ?array {
        return $this->handleRPC( function () {
            return $this->getServer()->listunspent(0);
        });
    }

    /**
     * @param string $address
     * @return string
     */
    protected function getPrivateKey(string $address): string {
        $key = $this->handleRPC(function () use ($address) {
            return $this->getServer()->dumpprivkey($address);
        });

        if (preg_match("/[^A-Za-z0-9]/", $key)) {
            return false;
        }

        return $key;
    }

    /**
     * @param \Closure $closure
     * @return null
     * @throws Exception
     */
    public function handleRPC(\Closure $closure) {

        $response = $closure->__invoke();

        if (isset($response[0])) {
            if ($response[0] === false) {

                if ($this->revokeIterationCount <= self::REVOKE_COUNT) {
                    $this->revokeIterationCount++;
                    sleep(1);
                    $this->handleRPC($closure);
                }

                throw new Exception(
                    'RPC error:, status code: ' . $response[1] . " message: " . (isset($response[2]) ? $response[2] : '')
                );
            }

            return $response[0];
        }

        return null;
    }

    /**
     * Get Rpc server.
     *
     * @return Rpc
     */
    public function getServer(): Rpc {
        if (empty($this->rpc)) {
            $this->rpc = Yii::$app->rpc;
        }

        return $this->rpc;
    }
}
