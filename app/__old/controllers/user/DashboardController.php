<?php

namespace app\controllers\user;

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
		if (Yii::$app->user->isGuest) return $this->goHome();

		$this->view->title = 'Dashboard';

		try {
			$user = Yii::$app->user->identity;

			/** @var array $parkingTypes List of parking types. */
			$parkingTypes = $this->getService('ParkingType')->getTypes();

			/** @var array $parkings List of parking models. */
			$parkings = $this->getService('Parking')->getLastForUser($user, $status = 1);

			/** @var array $payouts List of payout models. */
			$payouts = $this->getService('Payout')->getLastForUser($user);

			return $this->render('dashboard', compact('parkings','payouts','parkingTypes','user'));
		} catch (Exception $e) {
			die('Error: Something went wrong');
		}
	}
}