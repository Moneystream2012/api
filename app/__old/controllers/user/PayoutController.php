<?php

namespace app\controllers\user;

use Yii;
use app\controllers\AppController;

class PayoutController extends AppController {
	/**
	 * Displays dashboard.
	 *
	 * @uses PayoutService::getAllForUser
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		/** @var object $payoutService Parking service object. */
		$this->view->title = 'Payouts';

		try {
			/** @var array $payouts List of payouts for user. */
			$payoutService = $this->getService('Payout');

			$payouts = $payoutService->getAllForUser(Yii::$app->user->identity);

			return $this->render('payouts', $payouts);
		} catch(Exception $e) {
			exit('Error: Something went wrong');
		}
	}



	/**
	 * Get last payouts to display it on dashboard page.
	 *
	 * @api
	 * @return string
	 */
	public function actionGetLast() {
		try {
			return $this->getService('Payout')->getLastAjax();
		} catch (Exception $e) {
			return $this->sendError('You reached an error');
		}
	}
	
	
	
	/**
	 * Get certain payouts to display it on payouts page.
	 *
	 * @api
	 * @return string
	 */
	public function actionGetCertain() {
		try {
			return $this->getService('Payout')->getCertainAjax();
		} catch (Exception $e) {
			return $this->sendError('You reached an error');
		}
	}
}