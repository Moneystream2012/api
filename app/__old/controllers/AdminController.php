<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\SigninForm;

class AdminController extends AppController {
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
		
		$this->view->title = 'Sign in';

		$model = new SigninForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->redirect('?r=admin/dashboard/index');
		}

		return $this->render('signin', compact('model'));
	}



	/**
	 * Signup action.
	 *
	 * @return string
	 */
	public function actionSignup() {
		if (!Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Sign up';

		try {

			/** @var object $userService User service object. */
			$userService = $this->getService('User');

			/** @var array $response Signup status. */
			$response = $userService->signup();

			return $this->render('signup', compact('response'));
		} catch (Exception $e) {
			return $this->render('signup', ['response'=>array('status'=>0, 'error'=>'Some error happened!')]);
		}

	}



	/**
	 * Signout action.
	 */
	public function actionSignout() {
		Yii::$app->user->logout();
		
		return $this->goHome();
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
}