<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

class PayoutController extends AppController {
	/**
	 * Displays list of payouts.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		/** @var object $payoutService Parking service object. */
		$this->view->title = 'Payouts';

		try {
			/** @var \app\services\PayoutService $payoutService List of payouts for user. */
			$payoutService = $this->getService('Payout');

            /** @var array $payoutsData */
			$payoutsData = $payoutService->getAllForAllUsers();

			return $this->render('list', $payoutsData);
		} catch(Exception $e) {
			exit('Error: Something went wrong');
		}
	}
}