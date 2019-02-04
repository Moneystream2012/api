<?php

namespace app\controllers\user;

use Yii;
use app\controllers\AppController;

/**
 * Controller for user's setting.
 */
class SettingController extends AppController {
	/**
	 * Displays setting for user.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Setting';

		try {
			/** @var object $user User model. */
			$user = $this->getService('User')->getUser();

			/** @var array $dataFor2FA Must contain secret code and img URL for 2FA. */
			$dataFor2FA = $this->getService('User')->get2FAData();

			return $this->render('setting', compact('dataFor2FA', 'user'));
		} catch (Exception $e) {
			die('Error: Something went wrong');
		}
	}



	/**
	 * Display page for changing user's password.
	 *
	 * @author Alexandr Parkhomenko <mrsadrek@gmail.com>
	 * @return string
	 */
	public function actionChangePassword() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();
		
		return $this->render('change-password');
	}



	/**
	 * Display page for changing user's email for notifications.
	 *
	 * @author Alexandr Parkhomenko <mrsadrek@gmail.com>
	 * @return string
	 */
	public function actionEmailNotification() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();
		
		return $this->render('email-notification');
	}



	/**
	 * Setting page for 2fa.
	 *
	 * @author Vladyslav <xinonghost@gmail.com>
	 * @return string
	 */
	public function action2fa() {
		if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
			return $this->goHome();

		$this->view->title = '2FA setting';

		try {
			$userService = $this->getService('User');
			$response = $userService->switch2FA(Yii::$app->user->identity);
			$data = $userService->get2FAData(Yii::$app->user->identity);

			return $this->render('2fa', compact('response', 'data'));
		} catch (Exception $e) {
			die('Error: Some error happened');
		}
	}



	////////////////////////////
	// AJAX ///////////////////
	//////////////////////////
	/**
	 * Change user's password.
	 *
	 * @author Alexandr Parkhomenko <mrsadrek@gmail.com>
	 * @return string
	 */
	public function actionChangePasswordProcess() {
		try {
			return $this->getService('Setting')->changePassword();
		} catch (Exception $e) {
			return $this->sendError('System error happened');
		}
	}



	/**
	 * Change user's email for notifications.
	 *
	 * @author Alexandr Parkhomenko <mrsadrek@gmail.com>
	 * @return string
	 */
	public function actionEmailNotificationProcess() {
		try {
			return $this->getService('Setting')->emailNotification();
		} catch (Exception $e) {
			return $this->sendError('System error happened');
		}
	}



	/**
	 * Change checkbox user's email for notifications.
	 *
	 * @author Alexandr Parkhomenko <mrsadrek@gmail.com>
	 * @return string
	 */
	public function actionEmailEnableNotificationProcess() {
		try {
			return $this->getService('Setting')->emailEnableNotification();
		} catch (Exception $e) {
			return $this->sendError('System error happened');
		}
	}



	///////////////////////////////
	// 2FA ///////////////////////
	/////////////////////////////
	/**
	 * Get new 2FA data via AJAX.
	 *
	 * @api
	 * @return string
	 */
	public function actionGetNew2faData() {
		try {
			return $this->getService('User')->refresh2FAData();
		} catch (Exception $e) {
			return $this->sendError('You reached an error: '.$e->getMessage());
		}
	}



	/**
	 * Switch 2FA.
	 *
	 * @api
	 * @return string
	 */
	public function actionSwitch2fa() {
		try {
			return $this->getService('User')->switch2FA();
		} catch (Exception $e) {
			return $this->sendError('Error: '.$e->getMessage());
		}
	}
}