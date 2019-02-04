<?php

namespace app\controllers\user;

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
			
			$filter = $parkingService->getAmountOfParkings(Yii::$app->user->identity);
			return $this->render('parking', array_merge($parkings, $filter));
		} catch (Exception $e) {
			exit('Error: Something went wrong');
		}
	}



	/**
	 * Verify if all data are pass the requirements.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return array
	 */
	public function actionValidateData () {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		try {
			return $this->sendJSON($this->getService('Parking')->validateData());
		} catch (Exception $e) {
			return $this->sendError('You have reached the error');
		}
	}



	/**
	 * Verify data and add new parking.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return array
	 */
	public function actionAdd() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		try {
			$parkingService = $this->getService('Parking');

			return $this->sendJSON($parkingService->addByAjax());
		} catch (Exception $e) {
			return $this->sendError('You have reached the error');
		}
	}



	/**
	 * Cancel parking.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return array
	 */
	public function actionCancel() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		try {
			$parkingService = $this->getService('Parking');

			return $this->sendJSON($parkingService->cancel());
		} catch (Exception $e) {
			return $this->sendError('You have reached the error');
		}
	}



	/**
	 * Get list of last parkings.
	 *
	 * @api
	 * @return string
	 */
	public function actionGetLast() {
		try {
			// Abort if request not through AJAX.
			if (!Yii::$app->request->isAjax)
				return $this->sendError('Bad request', $statusCode = 400);

			// Abort is user not authorised.
			if (Yii::$app->user->getIsGuest())
				return $this->sendError('You are not authorised', $statusCode = 301);

			return $this->getService('Parking')->getLastActiveForUserAjax(Yii::$app->user->identity);
		} catch (Exception $e) {
			return $this->sendError('You reached an error');
		}
	}



	/**
	 * Get list of parkings via AJAX.
	 *
	 * @api
	 * @return string
	 */
	public function actionGetListAjax() {
		try {
			// Abort if request not through AJAX.
			if (!Yii::$app->request->isAjax)
				return $this->sendError('Bad request', $statusCode = 400);

			return $this->getService('Parking')->getListForUserAjax();
		} catch (Exception $e) {
			return $this->sendError('You reached an error');
		}
	}
}