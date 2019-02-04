<?php

namespace app\controllers\admin;

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
			$notifications = $notificationService->getLastForUser();

			return $this->render('notifications', $notifications);
		} catch (Exception $e) {
			die('Error: Something went wrong');
		}
	}



	/**
	 * Add new notification.
	 *
	 * @return string
	 */
	public function actionAddNotification() {
		try {
			return $this->getService('Notification')->Add();
		} catch (Exception $e) {
			return $this->sendError('You have reached an error');
		}
	}
}