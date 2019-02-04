<?php

namespace app\controllers;

use Yii;

class SupportController extends AppController {
	/**
	 * Support chat page.
	 *
	 * @author Vladyslav Zaichuk
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Support chat';

		try {
			if (Yii::$app->user->isGuest)
				return $this->goHome();

			$user = Yii::$app->user->identity;
			if ($user == null)
				return $this->goHome();

			$room = $this->getService('SupportRoom')->getForUser($user->id);

			$messages = ($room != null) ?
				$this->getService('SupportMessage')->getLastMessages($room->id) :
				[];

			return $this->render('supports', compact('messages'));
		} catch(Exception $e) {
			exit('Error: Something went wrong');
		}
	}



	/**
	 * Add new message in support chat.
	 *
	 * @api
	 * @return string
	 */
	public function actionWriteMessage() {
		try {
			return $this->getService('SupportMessage')->add();
		} catch (Exception $e) {
			return $this->sendError('You reached some error');
		}
	}



	/**
	 * Get list of last messages.
	 *
	 * @api
	 * @return string
	 */
	public function actionFetchMessages() {
		try {
			return $this->getService('SupportMessage')->fetchMessages();
		} catch (Exception $e) {
			return $this->sendError('You have reached error');
		}
	}



	/**
	 * Old page for support page.
	 *
	 * @deprecated
	 */
	// public function actionSupports() {
	// 	if (Yii::$app->user->isGuest)
	// 			return $this->sendError('You are not authorised');

	// 	$user = Yii::$app->user->identity;

	// 	$room = $this->getService('SupportRoom')->getForUser($user->id);

	// 	$messages = ($room != null) ?
	// 		$this->getService('SupportMessage')->getLastMessages($room->id) :
	// 		[];

	// 	return $this->render('supports', compact('messages'));
	// }
}