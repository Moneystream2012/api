<?php

/**
 * Service worker for minexcoin.
 */

require_once(__DIR__ . '/Service.php');
require_once(__DIR__ . '/RPCServerService.php');

class MinexcoinService extends Service {
	private $_server = null;
	private $_logger = null;
	private $_transactionFee = 0.0005;
	private $_changeAddress = 'XGi9zFLLEdiwUUdQpm4qnbeJWrBx93D5jo';



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
	 * Get transaction.
	 *
	 * @param string $txid
	 * @return array
	 */
	public function getTransaction($txid) {
		$tx = $this->getServer()->gettransaction($txid);

		if ($tx == false || $this->getServer()->error)
			return $this->formErrorStatus($this->getServer()->error);

		return $this->formSuccessStatus($tx);
	}



	/**
	 * Crate new raw transaction.
	 *
	 * @return string|boolean
	 */
	public function createRawTransaction($txs, $outputs) {
		$hex = $this->getServer()->createrawtransaction($txs, $outputs);

		if ($hex == false || $this->getServer()->error) {
			$this->getLogger()->error('Cant create transaction: '.$this->getServer()->error);
			return $this->formErrorStatus($this->getServer()->error);
		}

		return $this->formSuccessStatus($hex);
	}



	/**
	 * Sign raw transaction.
	 *
	 * @return array
	 */
	public function signRawTransaction($hex, $txsPubKeys = null, $privKeys = null) {
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
	 * Get rpc server.
	 */
	private function getServer() {
		if ($this->_server != null) return $this->_server;

		return $this->_server = new RPCServerService('zak', 'zak');
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
}

class MinexcoinLogger {
	/**
	 * Log error.
	 */
	public function error($description) {
		// var_dump('Error: '.$description);
	}



	/**
	 * Log warning.
	 */
	public function warning($description) {
		// var_dump('Warning: '.$description);
	}



	/**
	 * Log notice.
	 */
	public function notice($description) {
		// var_dump('Notice: '.$description);
	}
}