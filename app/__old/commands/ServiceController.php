<?php

namespace app\commands;

use yii\console\Controller;

class ServiceController extends Controller {

	private $_services = array();

	/**
	 * Get service instance.
	 *
	 * @version 1.0.0
	 * @param string $serviceName Name of service to get instance.
	 * @return object
	 */
	public function getService($serviceName) {
		if (!isset($this->_services[$serviceName]) || $this->_services[$serviceName] == null) {
			$serviceClass = '\\app\\services\\'.($serviceName).'Service';
			$this->_services[$serviceName] = new $serviceClass();
		}
		return $this->_services[$serviceName];
	}

}