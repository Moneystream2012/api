<?php

namespace app\services;

use Yii;
use app\models\SupportRoom;
use app\models\SupportMessage;
use app\models\User;


/**
 * Service worker for support message.
 *
 * @property int $itemsPerPage Amount of items per page.
 * @package app\services
 */
class SupportMessageService extends Service {
	/**
	 * Add new message for support in support room.
	 *
	 * @param object $user User model.
	 * @return array
	 */
	public function add(SupportRoom $room = null, $user = null) {
		// var_dump($_POST['message']);
		// var_dump($user);
		// exit();
		if(isset($user))
			Yii::$app->user->identity = $user;


		//Neaded for android rest api.

		// if (!Yii::$app->request->isAjax)
		// 	return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
			return $this->sendError('You are not authorised', $code = 301);

		$user = Yii::$app->user->identity;

		if ($user == null)
			return $this->sendError('User not found');

		$message = trim($_POST['message']);
		$decodedMessage = htmlspecialchars($message);

		if (iconv_strlen($decodedMessage,'UTF-8') == 0)
			return $this->sendError('Message cant be empty.');

		if (iconv_strlen($decodedMessage,'UTF-8') > 1024)
			return $this->sendError('Message is too big.');

		if ($room == null && 
			($room = $this->getService('SupportRoom')->getForUser($user->id)) == null)
			return $this->sendError('Cant get chat room');

		$supportMessage = $this->create($decodedMessage, $user->id, $room->id);

		if ($supportMessage == null)
			return $this->sendError('Cant add message');

		$messages = $this->getLastMessages($room->id, $asArray = true);

		return $this->sendSuccess($messages);
	}



	/**
	 * Get list of last 10 messages.
	 *
	 * @param int $roomId Room identifier.
	 * @param boolean $asArray Return result as array of arrays or objects.
	 * @return array
	 */
	public function getLastMessages($roomId, $asArray = false) {
		$messagesQuery = SupportMessage::find()
			->where(['room_id'=>$roomId])
			->limit(10)
			->orderBy('created DESC');

		return array_reverse($asArray ? $messagesQuery->asArray()->all() : $messagesQuery->all());
	}



	/**
	 * Get list of last 10 messages.
	 *
	 * @param int $roomId Room identifier.
	 * @param boolean $asArray Return result as array of arrays or objects.
	 * @return array
	 */
	public function fetchMessages(SupportRoom $room = null) {
		if (Yii::$app->user->isGuest)
			return $this->sendError('You are not authorised');

		$user = Yii::$app->user->identity;

		if ($room === null &&
			($room = $this->getService('SupportRoom')->getForUser($user->id)) == null)
			return $this->sendError('Cant get chat room');

		return $this->sendSuccess($this->getLastMessages($room->id, $isArray = true));
	}



	/**
	 * Create new message.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param string $message Message content.
	 * @param int $userId User identifier.
	 * @param int $roomId Room identifier.
	 * @return object|null
	 */
	public function create($message, $userId, $roomId) {
		$supportMessage = new SupportMessage();
		$supportMessage->user_id = $userId;
		$supportMessage->room_id = $roomId;
		$supportMessage->user_seen = 0;
		$supportMessage->support_seen = 0;
		$supportMessage->message = $message;
		$supportMessage->created = time();


		$room = SupportRoom::find()->where(['id'=>$roomId])->one();
		$room->status = 1;

		if(!$room->save()) return null;

		return $supportMessage->save() ? $supportMessage : null;
	}

	public function getMessagesForRoom($id) {

	}

	public function writeMessageBySupport($id) {
		// Get room
		$room = $this->getService('SupportRoom')->find(['id'=>$id]);
		if ($room == null)
			return $this->sendError('Cant find room');
		
		// add
		return $message = $this->add($room);
	}


	/**
	* Get list of SupportMessages by id
	*/
	public function getSupportMessages(User $user){
		// $id = (int)htmlspecialchars($_REQUEST['from']);
		$room = SupportRoom::find()->where(['user_id'=>$user->id])->one();
		$messages = SupportMessage::find()->where(['user_id'=>$user->id,'room_id'=>$room->id])->limit(10)->asArray()->all();
		
		return $this->sendSuccess($messages);
	}

}