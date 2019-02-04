<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

class SupportController extends AppController {

	public function actionList() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Support';

		$supportRoomService = $this->getService('SupportRoom');

		$lists = $supportRoomService->getAllOpened();

		return $this->render('list', $lists);

	}



	/**
	 * View room for support.
     *
     * @return string
     */
	public function actionRoom($id = 0) {
	    if (Yii::$app->user->isGuest)
			return $this->goHome();

	    if (($id = intval($id)) < 1)
	        die('Wring room id');

	    /** @var \app\services\SupportRoomService $roomService */
        $roomService = $this->getService('SupportRoom');

        /** @var \app\services\UserService $userService */
        $userService = $this->getService('User');

        /** @var \app\services\SupportMessageService $messageService */
        $messageService = $this->getService('SupportMessage');

        /** @var \app\models\SupportRoom $room */
		$room = $roomService->find(['id'=>$id]);

		// $roomService->setSupportSeen($room);

		if ($room == null)
			die('Error: Room not found');

		$user = $userService->getInfo($room->user_id);

		if ($user == null)
			die('Error: User not found');

		$messages = ($room != null) ?
			$messageService->getLastMessages($room->id) :
			[];

		return $this->render('room', compact('messages', 'id', 'user'));
	}



	/**
	 * Write message to support room.
     *
     * @return string
     */
	public function actionWriteMessageBySupport($id){
		exit($this->getService('SupportMessage')->writeMessageBySupport($id));
	}
	


	/**
	 * Get list of messages for support room.
     *
     * @return string
     */
	public function actionFetchMessages($id) {
		$room = $this->getService('SupportRoom')->find(['id'=>$id]);

		if ($room == null)
			exit('Error: Room not found');

		exit($this->getService('SupportMessage')->fetchMessages($room));
	}



	/**
	 * Close support room.
     *
     * @return string
     */
	public function actionCloseRoom() {
	    /** @var int $roomId */
		$roomId = intval($_POST['id']);

		return $this->getService('SupportRoom')->closeRoom($roomId);
	}

	/**
	 * Принимает адрес пользователя, если он есть передаем в сервис, иначе выводит сообщение с ошибкой 
	 * @return string
	 */
	public function actionSearchUserByAddress(){
		if(!isset($_POST['userAddress'])) return $this->sendError('Incorrect address');
		$userService = $this->getService('User');
		$supportRoomService = $this->getService('SupportRoom');

		$user = $userService->searchUserByAddress($_POST['userAddress']);

		$room = $supportRoomService->getForUser($user['id']);
		return $this->sendSuccess($room['id']);

	}
}
