<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

class SubscriberController extends AppController {

	public function actionList() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();
		

		$this->view->title = 'Subscriber';

		$subcriberService = $this->getService('Subscriber');

		$lists = $subcriberService->getAllWithPagination();

		return $this->render('list', $lists);

	}
}