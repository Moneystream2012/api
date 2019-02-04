<?php

/**
 * Service worker for user.
 */

namespace app\services;

use Yii;
use yii\data\Pagination;
use app\models\User;
use Google\Authenticator\GoogleAuthenticator;
use app\models\OauthClients;


class UserService extends Service {
	private $_activationAddress = 'XRh824hwfNikbu5Lqo2DaeaPtv3shuuzWy';

# 2FA
	/**
	 * Switch 2FA.
	 *
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @param $user User's model instance.
	 * @return array Description of status.
	 */
	public function switch2FA() {
		if (!isset($_POST['code']) || !is_numeric($_POST['code']))
			return $this->sendError('Code not provided');

		$user = $this->getUser();
		if (!$user)
			return $this->sendError('You are not authorised', $code = 301);

		$authenticator = new GoogleAuthenticator();
		$tolerance = 1;
		$otp = strval($_POST['code']);
		
		if ($user->twofa_enabled == 1) {
			if (!$authenticator->verifyCode($user->twofa_secret, $otp, $tolerance))
				return $this->sendError('OTP validation failed');
			
			$user->twofa_enabled = 0;
			$user->twofa_secret = $authenticator->createSecret();

			if (!$user->save())
				return $this->sendError('Cant update data');

			$website = 'minexbank.com';
			$account = $user->address;
				
			return $this->sendSuccess([
				'state'=>0,
				'secret'=>$user->twofa_secret,
				'qrCodeUrl'=>$authenticator->getQRCodeGoogleUrl($account, $user->twofa_secret)
			]);
		} else {
			$secret = $user->twofa_secret;
			if (!$authenticator->verifyCode($secret, $otp, $tolerance))
				return $this->sendError('OTP validation failed');
		
			$user->twofa_enabled = 1;

			if (!$user->save())
				return $this->sendError('Cant update data');
			
			return $this->sendSuccess(['state'=>1]);
		}
	}



	/**
	 * Confirm 2FA.
	 * @version 1.0.0
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @param $user User's model instance.
	 * @return Array Description of status.
	 */
	public function confirm2FA($user = null) {
		if ($user == null && !($user = $this->getUser()))
			return array('status'=>0, 'response'=>'Unauthorized user');
		if (!isset($_POST['confirm']))
			return array('status'=>-1, 'response'=>'');
		if (!isset($_POST['code']) || !is_string($_POST['code']))
			return array('status'=>0, 'response'=>'Code not provided');

		$authenticator = new GoogleAuthenticator();
		$secret = $user->twofa_secret;
		$otp = $_POST['code'];
		$tolerance = 1;
		
		if ($authenticator->verifyCode($secret, $otp, $tolerance)) {
			// $user->twofa_passed = 1;
			Yii::$app->session->set('2FA_passed', true);

			// if (!$user->save())
				// return array('status'=>0, 'response'=>'Cant pass 2FA');
			
			$this->redirect('/?r=user/dashboard/index');
		} else
			return array('status'=>0, 'response'=>'OTP validation failed');
	}



	/**
	 * Get data for 2FA.
	 * @version 1.0.0
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @param $user User model instance.
	 * @return Array Data of 2FA.
	 */
	public function get2FAData() {
		$user = $this->getUser();
		if (!$user)
			$this->formErrorStatus('You are not authorised');

		/** @var object $authenticator GoogleAuthenticator class instance. */
		$authenticator = new GoogleAuthenticator();
		
		if ($user->twofa_secret == '') {
			$secret = $authenticator->createSecret();
			$user->twofa_secret = $secret;
		} else
			$secret = $user->twofa_secret;

		$website = 'minexbank.com';
		$account = $user->address;
		$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($account, $secret);

		return $this->formSuccessStatus(['secret'=>$secret, 'qrCodeUrl'=>$qrCodeUrl]);
	}



	/**
	 * Refresh 2FA data via AJAX.
	 *
	 * @api
	 * @return string
	 */
	public function refresh2FAData() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		$user = $this->getUser();
		if (!$user)
			return $this->sendError('You are not authorised');

		$authenticator = new GoogleAuthenticator();
		$secret = $authenticator->createSecret();

		$user->twofa_secret = $secret;
		if (!$user->save())
			return $this->sendError('Cant update data');

		$website = 'minexbank.com';
		$account = $user->address;
		$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($account, $secret);

		return $this->sendSuccess(['secret'=>$secret, 'qrCodeUrl'=>$qrCodeUrl]);
	}



	/**
	 * Check if 2FA is passed.
	 *
	 * @param boolean $jsonResponse Defines oredirect or json response.
	 * @return string
	 */
	public function check2FAPassed($jsonResponse = false) {
		$user = $this->getUser();

		if (!$user || $user->twofa_enabled == 0 || Yii::$app->session->get('2FA_passed'))
			return;

		if ($jsonResponse)
			return $this->sendError('You are not passed 2FA');

		return $this->redirect('/?r=user/confirm-2fa');
	}
# /2FA


# Selection
	/**
	 * Get user model by field.
	 * @version 1.0.0
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @param $field User's field.
	 * @param $value Value of field.
	 * @return $user User model or null.
	 */
	public function getUserBy($field, $value) {
		return ($user = User::model()->find($field." = :e", array(':e'=>$value))) ? $user : null;
	}



	/**
	 * Find user model.
	 *
	 * @param string $clause
	 * @param array $params
	 * @return \app\models\User
	 */
	public function find($clause, $params) {
		return User::find()->where($clause, $params)->one();
	}



	/**
	 * Get user by Yii app user.
	 *
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @return object|null
	 */
	public function getUser() {
		// if (!isset($_SESSION['uid']) || preg_match("/[^0-9A-z]/", $_SESSION['uid']))
		// 	return null;
		// if (!($user = User::model()->find('uid = :uid', array(':uid'=>$_SESSION['uid']))))
		// 	return null;
		// return $user;
		if (Yii::$app->user->isGuest)
			return null;

		return Yii::$app->user->identity;
	}



	/**
	 * Get all user's email.
	 * @version 1.0.0
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @param $order String, how to order selection.
	 * @return Array of String, user emails or empty.
	 */
	public function getAllUsersEmails($order = 'email') {
		$emails = array();
		$allUsers = $this->getAllUsers($order);
		if (empty($allUsers)) return array();

		foreach ($allUsers as $user)
			$emails[] = $user->email;
		return $emails;
	}


	/**
	 * Get user's activation status
	 *
	 * @api
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @return string
	 */
	public function getActivationStatus() {
		$user = Yii::$app->user->identity;

		if ($user == null)
			return $this->sendError('User not found', $code = 500);

		if ($user->status > 0)
			return $this->sendSuccess(true);

		$transactions = @json_decode(file_get_contents('http://159.203.177.14/api.php?r=getreceivedtransactionsofaddress&address='.$this->_activationAddress), true);

		if ($transactions && $transactions['status'] == 1) {
			foreach (array_reverse($transactions['data']) as $txid => $amount) {
				if ($amount < 0.00001)
					continue;
				$senderAddress = @json_decode(file_get_contents('http://159.203.177.14/api.php?r=getsendersoftransaction&txid='.$txid));

				if (!$senderAddress || $senderAddress['status'] == 0 || count($senderAddress['data']) == 0)
					continue;

				foreach ($senderAddress['data'] as $address) {
					if ($user->address == $address) {
						$user->status = 1;
						$user->save();
						return $this->sendSuccess(true);
					}
				}
			}
		}

		return $this->sendSuccess(false);
	}



	/**
	 * @todo Add phpdoc.
     */
    public function filterUsers() {
		$allUsers = User::find()->count();
		$confirmedUsers = User::find()->where(['status'=>1])->count();
		$unconfirmedUsers = User::find()->where(['status'=>0])->count();
		
		return compact('allUsers', 'confirmedUsers', 'unconfirmedUsers');
	}

	/**
	 * Get all users.
	 *
	 * @return array
	 */
	public function getAll() {
		
		
		if( !isset($_GET['status']) || intval($_GET['status']) > 2 || intval($_GET['status']) < 0) {
			$userQuery = User::find()->orderBy('created DESC');
		} else {
			$userQuery = User::find()->where(['status'=> intval($_GET['status']) ])->orderBy('created DESC');
		}


		$pages = new Pagination(['totalCount' => $userQuery->count(), 'pageSize' => $this->itemsPerPage]);
		
		$pages->pageSizeParam = false; // No needed, page size is defined manually.
		
		$users = $userQuery->offset($pages->offset)
			->limit($pages->limit)
			->all();

		return compact('users', 'pages');
	}



	/**
	 * @todo Add phpdoc.
     */
	public function getStatistic()	{
		$totalWebUsers = User::find()->count();
		$unconfirmedWebUsers = User::find()->where(['status'=>0])->count();
		$confirmedWebUsers = User::find()->where(['status'=>1])->count();

		return compact('totalWebUsers','unconfirmedWebUsers','confirmedWebUsers');
	}


	/**
	 * @deprecated
     */
	public function getInfo($userId) {
		return User::find()->where(['id'=>$userId])->one();
	}

	/**//**
	 * Проверяем правильный ли адрес, существует ли такой пользователь если всё хорошо передаем его дальше. Где в итоге перенаправляем на страницу с информацией о пользователе.
	 * @param type $userAddress 
	 * @return string
	 */
	public function searchUserByAddress($userAddress) {
		if(preg_match("/[^A-Za-z0-9]/",$userAddress)) return $this->sendError('Invalid address');
		$user = User::find()->where(['address'=>$userAddress])->asArray()->one();
		if($user == null ) return $this->sendError('User not found');

		return $user;

	} 
# /Selection


# Checkers
	/**
	 * Does the user has admin permissions.
	 * @version 1.0.0
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @param $user User model instance.
	 * @return Boolean.
	 */
	public function isAdmin($user, $reject = true, $redirectUrl = '') {
		if ($user->status == 2)
			return true;
		if (!$reject)
			return false;
		if ($redirectUrl != '')
			header("Location: ".$redirectUrl);
		exit('301');
	}
# /Checkers


# Login
	/**
	 * Sign up user.
	 *
	 * @return array
	 */
	public function signup() {
		$data = Yii::$app->request->post();
		if (!isset($data['signup-button']))
			return array('status'=>-1);

		if (!isset($data['address']) || trim($data['address']) == '')
			return $this->formErrorStatus('Address not provided');

		if (!isset($data['password']) || trim($data['password']) == '')
			return $this->formErrorStatus('Password not provided');

		if (preg_match("/[^A-Za-z0-9]/", $data['address'])
				|| iconv_strlen($data['address'], 'UTF-8') < 26
				|| iconv_strlen($data['address'], 'UTF-8') > 35
				|| ($data['address'][0] !== 'X'))
			return $this->formErrorStatus('Incorrect address');

		if (iconv_strlen($data['password'], 'UTF-8') < 6)
			return $this->formErrorStatus('Password is too short');

		if (!isset($data['repassword']) || $data['password'] !== $data['repassword'])
			return $this->formErrorStatus('Repeat password doesnt match');

		$userExists = User::find()->where("address = '".$data['address']."'")->one();
		if ($userExists)
			return $this->formErrorStatus('User with specified address is already exists');

		$user = new User();
		$user->address = $data['address'];
		$user->verify_address = '';
		$user->password = sha1(md5($data['password']));
		$user->balance = '0';
		$user->status = 0;
		$user->created = time();
		$user->twofa_enabled = 0;
		$user->twofa_passed = 0;
		$user->email_notification = 0;
		$user->email = '';
		$user->country = '';

		if (!$user->validate())
			return $this->formErrorStatus('Cant add new user account');
		
		Yii::$app->session->set('user-registration-data', [
				'address' => $user->address,
				'password' => $user->password,
				'created' => $user->created
			]);

		return $this->redirect('/?r=user/verify-address');

		if (!$user->validate() || !$user->save())
			return $this->formErrorStatus('Cant add new user account');

		// Log in registered user.
		// Yii::$app->user->login($user, 3600*24*30 : 0);
		return $this->redirect('?r=user/signin');

		return $this->formSuccessStatus('New account registered');
	}



	/**
	 * Check if user typed registering data.
	 */
	public function isRegisterDataEntered() {
		return Yii::$app->session->get('user-registration-data') != null;
	}



	/**
	 * Verify address.
	 */
	public function handleAddressVerification($data) {
		if (!$this->isRegisterDataEntered())
			return $this->redirect('/?r=user/signup');

		if (!isset($data['verify']))
			return ['status'=>-1];

		if (!isset($data['signature']) || !$data['signature'])
			return $this->formErrorStatus('Signature not provided');

		$registerData = Yii::$app->session->get('user-registration-data');

		if (!$this->getService('Minexcoin')->verifyMessage($registerData['address'], $data['signature'], 'minexbank'))
			return $this->formErrorStatus('Signature isn\'t verified');

		$balanceInfo = $this->getService('Core')->getAddressBalance($registerData['address']);

		if ($balanceInfo['status'] == 0)
			return $this->formErrorStatus(isset($balanceInfo['error']) ? $balanceInfo['error'] : 'Balance error');

		$user = new User();
		$user->address = $registerData['address'];
		$user->verify_address = '';
		$user->password = $registerData['password'];
		$user->balance = (string)$balanceInfo['data'];
		$user->status = 1;
		$user->created = $registerData['created'];
		$user->twofa_enabled = 0;
		$user->twofa_passed = 0;
		$user->email_notification = 0;
		$user->email = '';
		$user->country = '';

		if (!$user->validate() || !$user->save())
			return $this->formErrorStatus('Cant add new user account');

		Yii::$app->user->login($user, 3600*24*30);

		return $this->redirect('?r=user/dashboard/index');
	}



	/**
	 * Sync balance of account by api.
	 *
	 * @return string
	 */
	public function syncBalanceApi(User $user) {
		$balanceInfo = $this->getService('Core')->getAddressBalance($user->address);

		if ($balanceInfo['status'] == 0) return $this->formErrorStatus($balanceInfo['error']);

		$user->balance = (string)$balanceInfo['data'];

		if (!$user->save())
			return $this->formErrorStatus('Cant save data');

		return $this->formSuccessStatus($user->balance);
	}

		/**
	 * Sign up user.
	 *
	 * @return array
	 */
	public function signupApi() {
		$data = Yii::$app->request->post();

		if (!isset($data['address']) || trim($data['address']) == '')
			return $this->formErrorStatus('Address not provided');

		if (!isset($data['password']) || trim($data['password']) == '')
			return $this->formErrorStatus('Password not provided');

		if (preg_match("/[^A-Za-z0-9]/", $data['address'])
				|| iconv_strlen($data['address'], 'UTF-8') < 26
				|| iconv_strlen($data['address'], 'UTF-8') > 35
				|| ($data['address'][0] !== '1' && $data['address'][0] !== '3'))
			return $this->formErrorStatus('Incorrect address');

		if (iconv_strlen($data['password'], 'UTF-8') < 6)
			return $this->formErrorStatus('Password is too short');

		if (!isset($data['repassword']) || $data['password'] !== $data['repassword'])
			return $this->formErrorStatus('Repeat password doesnt match');

		$userExists = User::find()->where("address = '".$data['address']."'")->one();
		if ($userExists)
			return $this->formErrorStatus('User with specified address is already exists');

		$user = new User();
		$user->address = $data['address'];
		$user->verify_address = '';
		$user->password = $data['password'];
		$user->balance = 0;
		$user->status = 0;
		$user->created = time();
		$user->twofa_enabled = 0;
		$user->twofa_passed = 0;
		$user->email_notification = 0;
		$user->email = '';
		$user->country = '';

		if (!$user->validate() || !$user->save())
			return $this->formErrorStatus('Cant add new user account');

		$OauthClient = new OauthClients();
		$OauthClient->client_id = $user->address;
		$OauthClient->client_secret = $user->password;
		$OauthClient->redirect_uri = '	http://fake/';
		$OauthClient->grant_types = 'client_credentials authorization_code password implicit';
		$OauthClient->scope = NULL;
		$OauthClient->user_id = $user->id;

		if (!$OauthClient->validate() || !$OauthClient->save())
			return $this->formErrorStatus($OauthClient->getErrors());

		return $this->formSuccessStatus('New account registered');
	}
# /Login


# Tools
	/**
	 * Get verify BTC address for user.
	 *
	 * @api
	 * @return array
	 */
	public function getVerifyAddress() {
		if (Yii::$app->user->isGuest)
			return $this->formErrorStatus('You are not authorised');

		/** @var object $user User model object. */
		$user = Yii::$app->user->identity;

		if ($user->verify_address === '') {
			/** @var string|null $address Must contain new BTC address or null if fail. */
			$address = $this->fetchNewBTCAddress($user->id);

			if ($address == null)
				return $this->formErrorStatus('Cant fetch new verify address');

			$user->verify_address = $address;
			if (!$user->save())
				return $this->formErrorStatus('Cant update verify address');

			return array();
		} else
			return $this->formSuccessStatus($user->verify_address);
	}



	/**
	 * Get new BTC address from BTC API.
	 *
	 * @internal
	 * @param int $userId User model identifier.
	 * @return string|null
	 */
	private function fetchNewBTCAddress($userId) {
		//
	}
# /Tools
	
	
	/**
	 * Change user password
	 *
	 * @param object $user User model identifier.
	 * @return string {status: 0|1}
	 */
	public function changePassword(User $user){
		$oldpassword = $_REQUEST['oldpassword'];
		$newpassword = $_REQUEST['newpassword'];
		if($user->password !== sha1(md5($oldpassword))){
			return $this->sendError("Passwords do not coincide");
		}
		
		if(!preg_match('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/', $newpassword)){
			return $this->sendError("Incorrect new password. Password must contain 1 lowercase char, 1 uppercase char and 1 digit.");
		}
		
		$user->password = sha1(md5($newpassword));
		if(!$user->save())
			return $this->sendError('Cant save user data');
		
		return $this->sendSuccess("Password successfully changed");
	}
	
	
	
	/**
	 * Change user email
	 *
	 * @param object $user User model identifier.
	 * @return string {status: 0|1}
	 */
	public function changeEmail(User $user){
		$newemail = $_REQUEST['email'];
		
		if(!preg_match('/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/', $newemail)){
			return $this->sendError("Email isnt correct.");
		}
		
		$user->verify_address = $newemail;
		if(!$user->save())
			return $this->sendError('Cant save user data');
		
		return $this->sendSuccess("Email successfully changed");
	}
	
	
	
	/**
	 * Change email notification field
	 *
	 * @param object $user User model identifier.
	 * @return string {status: 0|1}
	 */
	public function changeEmailNotification(User $user){
		$user->email_notification = $user->email_notification === 1 ? 0 : 1;
		if(!$user->save())
			return $this->sendError('Cant save user data');
		
		return $this->sendSuccess("Email notifications successfully changed to " . $user->email_notification);
	}

		/**
	 * Confirm account
	 *
	 * @param object $user User model identifier.
	 * @return string {status: 0|1}
	 */
	public function confirmAccount(User $user){	
		return $this->sendSuccess((string)$user->status);
	}



	/**
	 * Sync balance of account.
	 *
	 * @return string
	 */
	public function syncBalance(User $user = null) {
		if ($user == null && Yii::$app->user->isGuest)
			return $this->formErrorStatus('You are not authorised');
		
		$user = $user ? : Yii::$app->user->identity;
		$balanceInfo = $this->getService('Core')->getAddressBalance($user->address);

		if ($balanceInfo['status'] == 0) return $this->formErrorStatus($balanceInfo['error']);

		$user->balance = (string)$balanceInfo['data'];

		if (!$user->save())
			return $this->formErrorStatus('Cant save data');

		return $this->formSuccessStatus($user->balance);
	}
}
