<?php

namespace app\controllers\rest;

use Yii;

class ApiController extends OauthController {
	/**
	 * Get token and send it to acquirer.
	 *
	 * @api
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @return string
	 */
	public function actionGetToken() {
		return $this->generateToken();
	}



	/**
	 * Get user info.
	 *
	 * @api
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @return string
	 */
	public function actionGetUserInfo() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

		$parkingInfo = $this->getService('Parking')->getInfo($user);

		return $this->sendSuccess([
			'status'=>(string)$user->status,
			'parked'=>(string)number_format($parkingInfo['parked'], 8),
			'available'=>(string)number_format($parkingInfo['available'], 8),
			'balance'=>(string)number_format($user->balance, 8),
			'address'=>(string)$user->address]
		);
	}
	
	
	
	/**
	 * Get parking rates.
	 *
	 * @api
	 * @return string
	 */
	public function actionGetParkingRates() {
		return $this->sendSuccess($this->getService('ParkingType')->getParkingTypes());
	}
	
	
	
	/**
	 * Get parkings.
	 * 
	 * @api
	 * @return string
	 */
	public function actionGetPayouts() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->sendSuccess($this->getService('Payout')->getPayoutsById($user));
	}
	
	
	
	/**
	 * Change password.
	 * 
	 * @api
	 * @return string
	 */
	public function actionChangePassword() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->getService('User')->changePassword($user);
	}
	
	
	
	/**
	 * Change email.
	 * 
	 * @api
	 * @return string
	 */
	public function actionChangeEmail() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->getService('User')->changeEmail($user);
	}
	
	
	
	/**
	 * Change email.
	 * 
	 * @api
	 * @return string
	 */
	public function actionChangeEmailNotification() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->getService('User')->changeEmailNotification($user);
	}


		/**
	 * Confirm Account.
	 * 
	 * @api
	 * @return string
	 */
	public function actionConfirmAccount() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->getService('User')->confirmAccount($user);
	}



		/**
	 * Get support messages.
	 * 
	 * @api
	 * @return string
	 */
	public function actionGetSupportMessages() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->getService('SupportMessage')->getSupportMessages($user);
	}


		/**
	 * Get notifications.
	 * 
	 * @api
	 * @return string
	 */
	public function actionGetNotifications() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
	
		return $this->getService('Notification')->getNotification($user);
	}


	/**
	 * Get parkings.
	 * 
	 * @api
	 * @return string
	 */
	public function actionGetParkings() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->sendSuccess($this->getService('Parking')->getParkingsForUser($user));
	}

	/**
	 * Get parkings.
	 * 
	 * @api
	 * @return string
	 */
	public function actionCreateParking() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		
		return $this->sendSuccess($this->getService('Parking')->addByApi($user));
	}

		/**
	 * Send support messages.
	 * 
	 * @api
	 * @return string
	 */
	public function actionSendSupportMessage() {
		/** @var object $user Must contain user model instance. */
		$user = $this->getUser();
		$room = $this->getService('SupportRoom')->getForUser($user->id);
		return $this->sendSuccess($this->getService('SupportMessage')->add($room,$user));
	}

	/**
	 * Sign up user.
	 * 
	 * @api
	 * @return string
	 */
	public function actionSignUp() {
		/** @var object $user Must contain user model instance. */
		return $this->getService('User')->signupApi();
	}	
}