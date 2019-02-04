<?php

namespace app\controllers;

use Yii;
use app\models\SigninForm;

class UserController extends AppController {
	/**
	 * There is no home page.
	 */
	public function actionIndex() {
		return $this->goHome();
	}



	/**
	 * Signin action.
	 *
	 * @return string
	 */
	public function actionSignin() {
		if (!Yii::$app->user->isGuest)
			return $this->goHome();
		// $this->layout = 'index';
		$this->view->title = 'Sign in';

		try {
			$model = new SigninForm();
			if ($model->load(Yii::$app->request->post()) && $model->login()) {
				Yii::$app->session->set('2FA_passed', false);
				return $this->redirect('?r=user/dashboard/index');
			}

			return $this->render('signin', compact('model'));
		} catch (Exception $e) {
			return $this->goHome();
		}
	}

	

	/**
	 * Signup action.
	 *
	 * @return string
	 */
	public function actionSignup() {
		if (!Yii::$app->user->isGuest)
			return $this->goHome();
		// $this->layout = 'index';
		$this->view->title = 'Sign up';

		try {
			/** @var object $userService User service object. */
			$userService = $this->getService('User');

			if ($userService->isRegisterDataEntered())
				return $this->redirect('/?r=user/verify-address');

			/** @var array $response Signup status. */
			$response = $userService->signup();
			
			return $this->render('signup', compact('response'));
		} catch (Exception $e) {
			
			return $this->render('signup', ['response'=>array('status'=>0, 'error'=>'Some error happened!')]);
		}
	}

	public function actionTerms() {
		// $this->layout = 'index';
		$this->view->title = 'Terms';
		

		return $this->render('terms');
	}

	/**
	 * Verify address.
	 */
	public function actionVerifyAddress() {
		try {
			$userService = $this->getService('User');
			$response = $userService->handleAddressVerification(Yii::$app->request->post());

			return $this->render('verify_address', compact('response'));
		} catch (Exception $e) {
			die('You reached an error');
		}
	}



	/**
	 * Signout action.
	 */
	public function actionSignout() {
		Yii::$app->user->logout();

		Yii::$app->session->destroy();

		return $this->redirect(Yii::$app->getHomeUrl());
	}



	/////////////////////////////////
	// AJAX requests ///////////////
	///////////////////////////////

	/**
	 * Get new or exists BTC address for user to verify account.
	 *
	 * @api
	 * @version 1.0.0
	 * @return string
	 * @deprecated
	 */
	public function actionGetVerifyAddress() {
		try {
			if (Yii::$app->user->isGuest)
				return $this->sendError('You are not authorised');

			/** @var object $userService User service object. */
			$userService = $this->getService('User');
			
			return $this->sendJSON($userService->getVerifyAddress());
		} catch (Exception $e) {
			return $this->sendError('Some error happened');
		}
	}



	/**
	 * Check account activation.
	 *
	 * @api
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @return string
	 */
	public function actionCheckActivation() {
		try {
			if (!Yii::$app->request->isAjax)
				return $this->sendError('Bad request', $code = 400);
			
			if (Yii::$app->user->isGuest)
				return $this->sendError('You are not authorised', $code = 301);
			
			exit($this->getService('User')->getActivationStatus());
		} catch (Exception $e) {
			return $this->sendError('Some error happened');
		}
	}



	/**
	 * Confirm 2FA page.
	 *
	 * @return string
	 */
	public function actionConfirm2fa() {
		$this->view->title = '2FA confirmation';
		
		try {
			$response = $this->getService('User')->confirm2FA();

			return $this->render('confirm_2fa', compact('response'));
		} catch (Exception $e) {
			die('You reached error');
		}
	}



	/**
	 * Discard 2FA confirmation.
	 */
	public function actionDiscard2fa() {
		return $this->redirect('/?r=user/signout');
	}

	public function actionRefreshBalance() {
		$balance = $this->getService('User')->syncBalance();
		$balanceInfo = $this->getService('Parking')->getInfo();
		// var_dump();exit;
		$data = [];
			$data['balance'] = $balance['data'];
			$data['parked'] = $balanceInfo['parked'];
			$data['available'] = $balanceInfo['available'] ;
		
		return  $this->sendSuccess($data);
	}
}