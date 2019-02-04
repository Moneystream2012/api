<?php

namespace app\controllers\rest;

use Yii;
use OAuth2\Server;
use OAuth2\Request;
use OAuth2\Storage\Pdo;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\RefreshToken;

class OauthController extends \yii\rest\Controller {
	protected $_services = array();



	/**
	 * Send JSON string as response.
	 * Support status codes.
	 *
	 * @internal
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
	 * @internal
	 *
	 * @version 1.0.0
	 * @param string $error Must contain description of error happened.
	 * @param int $statusCode Must contain error code for response.
	 */
	protected function sendError($error = null, $statusCode = 200) {
		if ($error == null)
			return $this->sendJSON(array('status'=>0), $statusCode);
		else
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
		if ($data == null)
			return $this->sendJSON(array('status'=>1));
		else
			return $this->sendJSON(array('status'=>1, 'data'=>$data));
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



	//////////////////////////////////
	// OAuth ////////////////////////
	////////////////////////////////
	/**
	 * Get oauth server.
	 *
	 * @todo Change password for db.
	 * @return object
	 */
	protected function getServer() {
		$dsn		= 'mysql:dbname=minexbank;host=localhost';
		$username   = 'root';
		// $password   = $_SERVER['HTTP_HOST'] == 'l.minexbank.com' ? 'mysql' : 'BPeWQfvEX1';
		$password   = 'mysql';
		$storage = new Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

		// Pass a storage object or array of storage objects to the OAuth2 server class
		$server = new Server($storage);

		// Add the "Client Credentials" grant type (it is the simplest of the grant types)
		$server->addGrantType(new ClientCredentials($storage));

		// Add the "Authorization Code" grant type (this is where the oauth magic happens)
		$server->addGrantType(new AuthorizationCode($storage));
		
		// add the grant type to your OAuth server
		$server->addGrantType(new RefreshToken($storage));

		return $server;
	}



	/**
	 * Vefify user and get user model.
	 *
	 * @version 1.0.0
	 * @internal
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @return mixed[] Array contains server instance and user model instance.
	 * Array['server'=>object, 'user'=>object]
	 */
	protected function getUser() {
		/** @var object $server Must contain instance of oauth server class. */
		$server = $this->getServer();

		// Handle a request to a resource and authenticate the access token
		if (!$server->verifyResourceRequest(Request::createFromGlobals())) {
			$server->getResponse()->send();
			return $this->sendError('Bad token data', $code = 400);
			die;
		}

		/** @var object $token Must contain instance of token. */
		$token = $server->getAccessTokenData(Request::createFromGlobals());
		
		/** @var int $userId Must contain identifier of user. */
		$userId = $token['user_id'];

		if ($userId < 1) return $this->sendError('User ID not found', $code = 401);
		
		$user = $this->getService('User')->find('id = :uid', [':uid'=>$userId]);
		if (!$user) return $this->sendError('User not found', $code = 401);

		return $user;
	}



	/**
	 * Get new token for user.
	 *
	 * @api
	 * @return string
	 */
	protected function generateToken() {
		$server = $this->getServer();

		// Handle a request for an OAuth2.0 Access Token and send the response to the client
		return $server->handleTokenRequest(Request::createFromGlobals())->send();
	}
}