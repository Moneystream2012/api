<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

/**
 * Controller for user dashboard.
 */
class DashboardController extends AppController {
	/**
	 * Displays dashboard.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();
		
		$this->view->title = 'Dashboard';

		try {
			/** @var object $parkingService Parking service object. */
			$parkingService = $this->getService('Parking');

			/** @var array $parkings List of parking models. */
			// $parkings = $parkingService->getLastForUser(Yii::$app->user->identity);

			/** @var object $payoutService Payout service object. */
			$payoutService = $this->getService('Payout');

			/** @var array $payouts List of payout models. */
			$payouts = $payoutService->getLastForUser(Yii::$app->user->identity);

			$users = $this->getService('User')->getStatistic();
			$totalWebUsers = $users['totalWebUsers'];
			$unconfirmedWebUsers = $users['unconfirmedWebUsers'];
			$confirmedWebUsers = $users['confirmedWebUsers'];

			$parkingStatistic = $parkingService->getStatistic();
			$parkingTotalType = $parkingStatistic['sumTypes'];
			$parkingType = $parkingStatistic['parkingType'];
			$parkingTotal = $parkingStatistic['parkingTotal'];

			return $this->render('dashboard', 
				compact(
					'parkings',
					'payouts',
					'totalWebUsers',
					'unconfirmedWebUsers',
					'confirmedWebUsers',
					'parkingTotalType',
					'parkingType',
					'parkingTotal'
				));

		} catch (Exception $e) {
			die('Error: Something went wrong');
		}
	}
}