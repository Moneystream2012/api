<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

/**
 * Controller for parkings.
 */
class UserController extends AppController {
	/**
	 * Displays users.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Users';

		try {
			/** @var object $userService User service object. */
			$userService = $this->getService('User');
			$userFilter = $userService->filterUsers();
			/** @var array $users List of users for user. */
			$data = $userService->getAll();
			
			return $this->render('user', array_merge($data, $userFilter));
		} catch (Exception $e) {
			exit('Error: Something went wrong');
		}
	}



	/**
	 * Verify if all data are pass the requirements.
	 *
	 * @todo Rename method to "actionValidateData".
	 * @todo Make handle case if was sent not AJAX request.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return array
	 */
	public function actionForm () {
		if (Yii::$app->request->isAjax) {
			$userService = $this->getService('User');

			exit($this->sendJSON($userService->validateData()));
		}
	}

	public function actionView($id = 0) {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'View';
		
		$id = intval($id);

        /** @var \app\services\UserService $userService */
        $userService = $this->getService('User');

        /** @var \app\services\ParkingService $parkingService */
        $parkingService = $this->getService('Parking');

        /** @var \app\services\SupportRoomService $supportRoomService */
        $supportRoomService = $this->getService('SupportRoom');

        /** @var array $user */
		$user = $userService->find('id = :id', [':id'=>$id]);

		/** @var array $filter */
		$filter = $parkingService->getAmountOfParkings($user);

		/** @var \app\models\Parking[] $parkings */
		$parkings = $parkingService->getLastForUser($user);

		/** @var \app\models\SupportRoom $room */
        $room = $supportRoomService->getForUser($user->id);
        $supportRoomId = $room->id;

		return $this->render('view',  compact('user','filter' ,'parkings', 'supportRoomId'));
	}

	/**//**
	 * Принимает адрес пользователя, если он есть передаем в сервис, иначе выводит сообщение с ошибкой 
	 * @return string
	 */
	public function actionSearchUserByAddress(){
		if(!isset($_POST['userAddress'])) return $this->sendError('Incorrect address');

		$user = $this->getService('User')->searchUserByAddress($_POST['userAddress']);
		if($user == null) return $this->sendError('User not found');

		return $this->sendSuccess($user);
		
	}
}