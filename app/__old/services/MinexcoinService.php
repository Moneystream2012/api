<?php

/**
 * Service worker for minexcoin.
 */

namespace app\services;

use Yii;
use app\services\RPCServerService;

class MinexcoinService extends Service {
	private $_server = null;
	private $_logger = null;
	private $_transactionFee = 0.0005;
	private $_changeAddress = 'XLcJLCfrGyyGP4cfVYPZ2P1scLoUvg8Tyg';



	/**
	 * Prepare transaction for payout.
	 *
	 * @return array
	 */
	public function prepareTransaction($address, $amount) {
		// Get available unspent transactions
		$availableTransactions = $this->getAvailable($amount);
		if (count($availableTransactions) < 1)
			return $this->formErrorStatus('There is not enough coins for transaction');

		// Generate transaction
		$createRawTransaction = []; // Inputs
		$signRawTransaction = []; // Sign inputs
		$privKeys = []; // Private keys
		$addressCache = []; // Cache for private keys
		
		$outputs = []; // Outputs
		$outputs[$address] = $amount; // Send to
		$totalAmount = 0; // Total amount of coins for transaction input
		
		foreach ($availableTransactions as $tx) {
			$totalAmount = round($totalAmount + $tx['amount'], 8, PHP_ROUND_HALF_DOWN);
			
			$createRawTransaction[] = ['txid' => $tx['txid'], 'vout' => $tx['vout']];
		}

		$change = round($totalAmount - $amount - $this->_transactionFee, 8, PHP_ROUND_HALF_DOWN);
		if ($change >= 0.0001)
			$outputs[$this->_changeAddress] = $change;

		// foreach ($availableTransactions as $tx) {
			// $signRawTransaction[] = [
			// 	'txid' => $tx['txid'],
			// 	'vout' => $tx['vout'],
			// 	'scriptPubKey' => $tx['scriptPubKey']
			// ];

			// if (!in_array($tx['address'], $addressCache)) {
			// 	$addressCache[] = $tx['address'];
			// 	$priv = $this->getPrivateKey($tx['address']);

			// 	if (!$priv)
			// 		return $this->formErrorStatus('Cant determine private key from address');

			// 	$privKeys[] = $priv;
			// }
		// }

		$hex = $this->createRawTransaction($createRawTransaction, $outputs);

		if ($hex == false)
			return $this->formErrorStatus('Cant create transaction');

		$response = $this->signRawTransaction($hex, $signRawTransaction, $privKeys);

		return $response;
	}



	/**
	 * Send transaction.
	 *
	 * @param string $address
	 * @param numeric $amount
	 * @return array
	 */
	public function stageTransaction($address, $amount) {
		$hexData = $this->prepareTransaction($address, $amount);

		if ($hexData['status'] == 0)
			return $hexData;

		$txid = $this->getServer()->sendrawtransaction($hexData['data']);

		if ($txid == false)
			return $this->formErrorStatus('Cant send transaction: '.$this->getServer()->error);

		return $this->formSuccessStatus($txid);
	}



	/**
	 * Send transaction.
	 *
	 * @param string $hex
	 * @return array
	 */
	public function sendTransaction($hex) {
		$txid = $this->getServer()->sendrawtransaction($hex);

		if ($txid == false || $this->getServer()->error)
			return $this->formErrorStatus('Cant send transaction: '.$this->getServer()->error);

		return $this->formSuccessStatus($txid);
	}



	/**
	 * Description
	 *
	 * @author Alexandr Parkhomneko <mrsadrek@gmail.com>
	 * @param string $address 
	 * @return array
	 */
	// public function getBalance($address) {
	// 	$url = 'https://blockchain.info/rawaddr/'.$address;
	// 	$response = $this->sendRequest($url);

	// 	$result = @json_decode($response, true);

	// 	if ($result == null)
	// 		return $this->formErrorStatus('Wrong response');

	// 	if (!isset($result["final_balance"]))
	// 		return $this->formErrorStatus('Balance not found');

	// 	$balance = (string)$result["final_balance"] / 100000000;

	// 	return $this->formSuccessStatus($balance);
	// }



	/**
	 * Decode raw transaction.
	 *
	 * @param string $hex
	 * @return array
	 */
	public function decodeRawTransaction($hex = '') {
		if (!$hex)
			return $this->formErrorStatus('Cant decode raw transaction: Empty hex provided');

		$decodedTransaction = $this->getServer()->decoderawtransaction($hex);

		if ($decodedTransaction == false || $this->getServer()->error)
			return $this->formErrorStatus('Cant decode raw transaction: '.$this->getServer()->error);

		return $this->formSuccessStatus($decodedTransaction);
	}



	/**
	 * Send transaction from remote server.
	 *
	 * @param string $txid
	 * @param string $address
	 * @return array
	 */
	public function sendTransactionRemote($txid, $address) {
		$key = '$s7FG32309DFG32%$^0)gff@-f()nhjEggf50-f65876gwh7ek9W8';
		$signature = sha1(md5($txid.$address.$key));

		return $this->sendRequest('http://104.236.126.203/send.php', compact('txid', 'address', 'signature'));
	}



	/**
	 * Crate new raw transaction.
	 *
	 * @return string|boolean
	 */
	private function createRawTransaction($txs, $outputs) {
		$hex = $this->getServer()->createrawtransaction($txs, $outputs);

		if ($hex == false) {
			$this->getLogger()->error('Cant create transaction: '.$this->getServer()->error);
		}

		if (preg_match("/[^A-Za-z0-9]/", $hex))
			return false;

		return $hex;
	}



	/**
	 * Sign raw transaction.
	 *
	 * @return array
	 */
	private function signRawTransaction($hex, $txsPubKeys, $privKeys) {
		$response = $this->getServer()->signrawtransaction($hex/*, $txsPubKeys, $privKeys*/);

		if ($response == false) {
			$this->getLogger()->error('Cant sign transaction: '.$this->getServer()->error);
			return $this->formErrorStatus($this->getServer()->error);
		}

		if (!is_array($response))
			return $this->formErrorStatus('Response is not array');

		if (!isset($response['hex']) || !isset($response['complete']))
			return $this->formErrorStatus('Wrong response array');

		if ($response['complete'] == false)
			return $this->formErrorStatus('Transaction is not completed');

		return $this->formSuccessStatus($response['hex']);
	}



	/**
	 * Get private key.
	 *
	 * @return string|boolean
	 */
	private function getPrivateKey($address) {
		$key = $this->getServer()->dumpprivkey($address);

		if ($key == false) {
			$this->getLogger()->error('Cant get privkey from '.$address.' : '.__FILE__.':'.__LINE__);
		}

		if (preg_match("/[^A-Za-z0-9]/", $key))
			return false;
		
		return $key;
	}



	/**
	 * Get list of available transactions.
	 *
	 * @return array
	 */
	private function getUnspent($from = null, $to = null) {
		if ($from !== null && $to !== null)
			$unspent = $this->getServer()->listunspent($from, $to);
		elseif ($from !== null)
			$unspent = $this->getServer()->listunspent($from);
		else
			$unspent = $this->getServer()->listunspent();

		if ($unspent == false) {
			$this->getLogger()->error('RPC returned false: '.__FILE__.':'.__LINE__);
			return [];
		}

		if (!is_array($unspent) || count($unspent) < 1) {
			$this->getLogger()->warning('RPC returned not array or empty: '.__FILE__.':'.__LINE__);
			return [];
		}

		return $unspent;
	}



	/**
	 * Get unspent for new transaction.
	 *
	 * @return array
	 */
	private function getAvailable($amount) {
		$available = $this->getUnspent(1);

		if (count($available) == 0)
			return [];

		$target = $amount;
		$resultSet = [];
		foreach ($available as $transaction) {
			$target -= $transaction['amount'];
			$resultSet[] = $transaction;

			if ($target <= -($this->_transactionFee)) return $resultSet;
		}

		$this->getLogger()->warning('There is no available transactions for output: '.__FILE__.':'.__LINE__);
		return [];
	}



	/**
	 * Get rpc server.
	 */
	private function getServer() {
		if ($this->_server != null) return $this->_server;

		return $this->_server = new RPCServerService('user', 'password');
	}



	/**
	 * @return array
	 */
	private function sendRequest($url, $params) {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		
		$response = curl_exec($curl);

		if (curl_errno($curl))
			return $this->formErrorStatus(curl_error($curl));

		curl_close($curl);

		$response = @json_decode($response, true);


		if (!$response)
			return $this->formErrorStatus('Cant decode response');

		if ($response['status'] == 0)
			return $this->formErrorStatus($response['error']);

		return $this->formSuccessStatus($response['data']);
	}



	/**
	 * Get logger object.
	 *
	 * @return object
	 */
	private function getLogger() {
		if ($this->_logger == null)
			$this->_logger = new MinexcoinLogger();

		return $this->_logger;
	}



	////////////////////////////////////
	// Syncing user balance ///////////
	//////////////////////////////////
	private $_APIUrl = 'http://minexexplorer.com/api.php?r=';

	/**
	 * Get balance of address.
	 *
	 * @param string $address MNX address.
	 * @return float
	 */
	public function getAddressBalance($address) {
		$balanceInfo = @json_decode(file_get_contents($this->_APIUrl.'getaddressbalance&address='.$address), true);
		return $balanceInfo ? : $this->formErrorStatus('Cant get balance data');
	}



	/**
	 * Verify message.
	 */
	public function verifyMessage($address, $signature, $message) {
		return $this->getServer()->verifymessage($address, $signature, $message) == true;
	}
}

class MinexcoinLogger {
	/**
	 * Log error.
	 */
	public function error($description) {
		var_dump('Error: '.$description);
	}



	/**
	 * Log warning.
	 */
	public function warning($description) {
		var_dump('Warning: '.$description);
	}



	/**
	 * Log notice.
	 */
	public function notice($description) {
		var_dump('Notice: '.$description);
	}
}
