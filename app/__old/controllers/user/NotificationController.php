<?php

namespace app\controllers\user;

use Yii;
use app\controllers\AppController;

/**
 * Controller for user's notifications.
 */
class NotificationController extends AppController {
	/**
	 * Displays notifications for user.
	 *
	 * @author Alexandr Parkhomenko <mrsadrek@gmail.com>
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Notification';

		try {
			/** @var object $notificationService Notification service object. */
			$notificationService = $this->getService('Notification');

			/** @var array $notifications List of notification models. */
			// $notifications = $notificationService->getLastForUser(Yii::$app->user->identity);
			$notifications = $notificationService->getLastForUser();


			return $this->render('notifications', $notifications);
		} catch (Exception $e) {
			exit('Error: Something went wrong');
		}
	}



	/**
	 * Get list of last notification.
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

			return $this->getService('Notification')->getLastForUserAjax(Yii::$app->user->identity);
		} catch (Exception $e) {
			return $this->sendError('You reached an error');
		}
	}



	/**
	 *
	 */
	public function actionCancel() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		try {
			$notificationService = $this->getService('Notification');

			return $this->sendJSON($notificationService->cancel());
		} catch (Exception $e) {
			return $this->sendError('You have reached the error');
		}
	}



	/**
	 * Set certain notification as seen.
	 *
	 * @api
	 * @return string
	 */
	public function actionSetSeen() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		try {
			return $this->getService('Notification')->setAsSeen();
		} catch (Exception $e) {
			return $this->sendError('You have reached the error');
		}
	}
}