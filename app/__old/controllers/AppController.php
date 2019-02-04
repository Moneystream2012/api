<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AppController extends Controller {
	protected $_services = array();



	/**
	 * Before calling action.
	 */
	public function beforeAction($action) {
		if (!parent::beforeAction($action))
			return false;

		$exceptedActions = ['error', 'confirm-2fa', 'discard-2fa', 'signout'];

		# WARNING: Looping may appear.
		if (!in_array($action->id, $exceptedActions))
			$this->getService('User')->check2FAPassed($jsonResponse = Yii::$app->request->isAjax ? true : false);
		
		return true;
	}



	/**
	 * Send JSON string as response.
	 * Support status codes.
	 *
	 * @version 1.0.1
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param mixed[] $data Must contain associative array.
	 * @param int $statusCode Must contain response HTTP status code.
	 */
	protected function sendJSON($data, $statusCode = 200) {
		header('Content-Type: application/json');
		http_response_code($statusCode);
		echo json_encode($data);
		exit;
	}



	/**
	 * Send JSON with error.
	 *
	 * @version 1.0.0
	 * @param string $error Must contain description of error happened.
	 * @param int $statusCode Must contain error code for response.
	 */
	protected function sendError($error, $statusCode = 200) {
		return $this->sendJSON(array('status'=>0, 'error'=>$error), $statusCode);
	}



	/**
	 * Send JSON with success.
	 *
	 * @version 1.0.0
	 * @param mixed $data Must contain response data.
	 * @return string
	 */
	public function sendSuccess($data = null) {
		if ($data !== null)
			return $this->sendJSON(array('status'=>1, 'data'=>$data));
		else
			return $this->sendJSON(array('status'=>1));
	}



	/**
	 * Get service instance.
	 * @version 1.0.0
	 * @param string $serviceName Name of service to get instance.
	 * @return object
	 * @throws Exception
	 */
	public function getService($serviceName) {
		if (!isset($this->_services[$serviceName]) || $this->_services[$serviceName] == null) {
			$serviceClass = '\\app\\services\\'.($serviceName).'Service';
			$this->_services[$serviceName] = new $serviceClass();
		}
		return $this->_services[$serviceName];
	}
}