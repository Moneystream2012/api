<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

/**
 * Controller for parkings.
 */
class ParkingController extends AppController {
	/**
	 * Displays parkings.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Parkings';

		try {
			/** @var object $parkingService Parking service object. */
			$parkingService = $this->getService('Parking');


			/** @var array $parkings List of parkings for user. */
			$parkings = $parkingService->getAllForUser(Yii::$app->user->identity);
			
			return $this->render('parkings', $parkings);
		} catch (Exception $e) {
			die('Error: Something went wrong');
		}
	}
	


	/**
	 * Displays debtss.
	 *
	 * @return string
	 */
	public function actionDebts() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Debts';

		try {
			/** @var object $parkingService Parking service object. */
			$parkingService = $this->getService('Parking');

			/** @var array $parkings List of parkings for user. */
			$debts = $parkingService->getDebts();
			
			return $this->render('debts', compact('debts'));
		} catch (Exception $e) {
			die('Error: Something went wrong');
		}
	}



	/**
	 * Show list of parkings.
	 *
	 * @return string
	 */
	public function actionList() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Parkings';

		try {
			$parkingService = $this->getService('Parking');

			$filter = $parkingService->getAmountOfParkings();

			$lists = $parkingService->getExtendedParkingsWithPagination();

			return $this->render('list', array_merge($lists, $filter));
		} catch (Exception $e) {
			die('You have reached an error');
		}
	}
}