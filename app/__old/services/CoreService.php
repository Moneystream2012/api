<?php

/**
 * Service worker for user.
 */

namespace app\services;

use Yii;
/*use yii\data\Pagination;
use app\models\User;*/
// use Google\Authenticator\GoogleAuthenticator;

class CoreService extends Service {
	/** @var object $_handler ... */
	private $_handler = null;
	private $_defaultHandlerName = 'Minexcoin';
	private $_handlerName = 'Minexcoin';


	/**
 	* Description
 	* @author Alexandr Parkhomneko <mrsadrek@gmail.com>
 	* @param string $address 
 	* @return array
 	*/
	public function getAddressBalance($address) {
		$this->checkHandler();
		return $this->_handler->getAddressBalance($address);
	}

	
	// public function checkParking() {
	// 	$this->checkHandler();
	// 	return $this->_handler->checkParking();
	// }


	/**
	 * Set handler.
	 * 
	 * @param string handlerName
	 * @return object
	 */
	public function setHandler($handlerName = null) {
		if ($handlerName == null)
			$handlerName = $this->_defaultHandlerName;

		$this->_handler = $this->getService($handlerName);
		return $this;
	}



	/**
	 * Check if handler was set, if not set it now.
	 * 
	 * @internal
	 * @return object
	 */
	private function checkHandler() {
		if ($this->_handler == null)
			$this->setHandler();

		return $this;
	}
}