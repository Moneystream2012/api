<?php

/**
 * Service class.
 */

namespace app\services;

abstract class Service {
	/** @var int $itemsPerPage Must contain amount of items displayed per page by default. */
	public $itemsPerPage = 10;

	private $_services = array();
# Lib
	/**
	 * Send JSON string as response.
	 * Support status codes.
	 * @version 1.0.1
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param mixed[] $data Must contain associative array.
	 * @param int $statusCode Must contain response HTTP status code.
	 */
	public function sendJSON($data, $statusCode = 200) {
		header('Content-Type: application/json');
		http_response_code($statusCode);
		echo json_encode($data);
		exit;
	}



	/**
	 * Send JSON with error.
	 * @version 1.0.0
	 * @param string $error Must contain description of error happened.
	 * @param int $statusCode Must contain error code for response.
	 */
	public function sendError($error, $statusCode = 400) {
		return $this->sendJSON(array('status'=>0, 'error'=>$error), $statusCode);
	}



	/**
	 * Send JSON with success.
	 * @version 1.0.0
	 * @param mixed $data Must contain response data.
	 */
	public function sendSuccess($data = null) {
		if ($data !== null)
			return $this->sendJSON(array('status'=>1, 'data'=>$data));
		else
			return $this->sendJSON(array('status'=>1));
	}



	/**
	 * Form error status array.
	 * @internal
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param string $error Error message.
	 * @return array
	 */
	protected function formErrorStatus($error = null) {
		if ($error === null) return array('status'=>0);
		else return array('status'=>0, 'error'=>$error);
	}



	/**
	 * Form success status array.
	 * @internal
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param string $data Data to return.
	 * @return array
	 */
	protected function formSuccessStatus($data = null) {
		if ($data === null) return array('status'=>1);
		else return array('status'=>1, 'data'=>$data);
	}



	/**
	 * Update session parameter.
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param array $data Data to change.
	 * @return boolean
	 */
	public function updateSession($data) {
		try {
			foreach ($data as $key => $value) \Yii::$app->session->set($key, $value);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}



	/**
	 * Update cookie parameter.
	 *
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param array $data Data to change.
	 * @return boolean
	 */
	public function updateCookie($data) {
		try {
			foreach ($data as $key => $value) {
				if (isset($value['path']))
					setcookie($key, $value['value'], $value['expire'], $value['path']);
				else
					setcookie($key, $value['value'], $value['expire']);
			}
			return true;
		} catch (Exception $e) {
			return false;
		}
	}



	/**
	 * Get session parameter.
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param mixed $key Var name for fetch.
	 * @return mixed
	 */
	public function getSession($key) {
		try {
			return \Yii::$app->session->get($key);
		} catch (Exception $e) {
			return null;
		}
	}



	/**
	 * Get cookie parameter.
	 *
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param mixed $key Var name for fetch.
	 * @return mixed
	 */
	public function getCookie($key) {
		try {
			return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
		} catch (Exception $e) {
			return null;
		}
	}



	/**
	 * Remove session parameter.
	 *
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param mixed $key Var name for fetch.
	 */
	public function removeSession($key) {
		unset($_SESSION[$key]);
	}



	/**
	 * Remove cookie parameter.
	 *
	 * @version 1.0.0
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param mixed $key Var name for fetch.
	 */
	public function removeCookie($key) {
		setcookie($key, '', time()-3600);
	}



	/**
	 * Redirect.
	 * @version 1.0.0
	 * @author Vladislav Zaichuk <xinonghost@gmail.com>
	 * @param string $url Redirect url.
	 */
	public function redirect($url = '/') {
		header("Location: ".$url);
		exit;
	}



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



	/**
	 * Send email.
	 *
	 * @version 1.0.0
	 * @uses https://minecoin.org/sendmail
	 */
	public function sendMail($to, $subject, $text) {
		$secret = 'Dfdfgert54yRTy';
		$data = array(
			'to' => $to,
			'subject' => $subject,
			'text' => $text,
			'signature' => md5($to.$secret)
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://minecoin.org/sendmail');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>json_encode($data)));
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_exec($ch);
		curl_close($ch);
	}
# /Lib
}