<?php

ini_set('display_errors', false);
// error_reporting(E_ALL | E_STRICT);

require_once(__DIR__ . '/MinexcoinService.php');

$sender = new Sender();

$sender->handleRequest();

class Sender {
	private $_mnxService = null;
	private $_fee = 0.0001;

	public function __construct() {
		$this->_mnxService = new MinexcoinService();
	}


	public function handleRequest() {
		if (!isset($_POST['txid']) || !isset($_POST['address']) || !isset($_POST['signature']))
			return $this->getService()->sendError('Not enough data');

		if (!is_string($_POST['txid']) || !is_string($_POST['address']) || !is_string($_POST['signature']))
			return $this->getService()->sendError('Wrong data');

		$txid = trim($_POST['txid']);
		$address = trim($_POST['address']);
		$signature = trim($_POST['signature']);

		$key = '$s7FG32309DFG32%$^0)gff@-f()nhjEggf50-f65876gwh7ek9W8';
		if ($signature != sha1(md5($txid.$address.$key)))
			return $this->getService()->sendError('Bad data');

		return $this->send($txid, $address);
	}



	private function send($txid, $address) {
		$tx = $this->getService()->getTransaction($txid);

		if ($tx['status'] == 0)
			return $this->getService()->sendError('Cant get: '.$tx['error']);

		$vout = $tx['data']['details'][0]['vout'];
		$amount = $tx['data']['details'][0]['amount'];
		$finalAmount = $amount - $this->_fee;

		$txs = [["txid"=>$txid, "vout"=>$vout]];
		$outputs = [''.$address.''=>$finalAmount];

		$created = $this->getService()->createRawTransaction($txs, $outputs);
		
		if ($created['status'] == 0)
			return $this->getService()->sendError('Cant create: '.$created['error']);

		$sign = $this->getService()->signRawTransaction($created['data']);
		if ($sign['status'] == 0)
			return $this->getService()->sendError('Cant sign: '.$sign['error']);

		$txidOut = $this->getService()->sendTransaction($sign['data']);
		if ($txidOut['status'] == 0)
			return $this->getService()->sendError('Cant send: '.$txidOut['error']);

		return $this->getService()->sendSuccess($txidOut['data']);
	}



	public function getService() {
		return $this->_mnxService;
	}
}