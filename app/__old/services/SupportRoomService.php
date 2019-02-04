<?php

namespace app\services;

use Yii;
use app\models\SupportRoom;
use app\models\SupportMessage;
use app\models\User;
use yii\data\Pagination;


/**
 * Service worker for support room.
 *
 * @property int $itemsPerPage Amount of items per page.
 * @package app\services
 */
class SupportRoomService extends Service {
	/**
	 * Create new room for chat with support.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param int $userId User identifier.
	 * @param int $supportId Support user identifier.
	 * @return object|null
	 */
	public function create($userId, $supportId) {
		$room = new SupportRoom();
		$room->user_id = $userId;
		$room->support_id = $supportId;
		$room->status = 0;
		$room->created = time();
		$room->closed = 0;

		return $room->save() ? $room : null;
	}



	/**
	 * Get room for user.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param int $userId User identifier.
	 * @return object|null
	 */
	public function getForUser($userId) {
		$roomExists = SupportRoom::find()->where(['user_id'=>$userId])->one();

		return $roomExists ? : $this->create($userId, 1);
	}



	/**
	 * @todo Add phpdoc.
     */
	public function getAllOpened() {
		$supportRoomsQuery = SupportRoom::find()->where(['status'=>1])->orderBy('created DESC');
		// ->where(['status'=>1])
		
		$pagination = new Pagination(['totalCount' => $supportRoomsQuery->count(), 'pageSize' => $this->itemsPerPage]);
		
		$pagination->pageSizeParam = false;
		
		$supportRooms = $supportRoomsQuery->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		$userIds = array_map(function($e) { return $e->user_id; }, $supportRooms);
		$roomIds = array_map(function($e) { return $e->id; }, $supportRooms);
		$users = [];
		$messages = [];
		
		if (count($userIds) > 0) {
			$usersAll = User::find()->where('id IN ('.join(',', $userIds).')')->all();
			foreach ($usersAll as $user)
				$users[$user->id] = $user->address;

			// $messagesAll = SupportMessage::find()->select(['room_id','message','created'])->groupBy(['room_id','message'])->orderBy('created ASC')->all();
			$messagesQueried = SupportMessage::findBySql('SELECT * FROM support_message WHERE id IN (SELECT max(id) FROM support_message GROUP BY room_id ORDER BY created DESC) AND room_id IN ('.join(',', $roomIds).')')->all();

			foreach ($messagesQueried as $message) {
				$messages[$message->room_id]['message'] = $message->message;
				$messages[$message->room_id]['created'] = $message->created;
			}
		}

		return compact('supportRooms', 'pagination','users','messages');
	}



	/**
	 * Get one model of SupportRoom.
     *
     * @param array $params
     * @return \app\models\SupportRoom
     */
	public function find($params) {
		return SupportRoom::find()->where($params)->one();
	}



	/**
	 * @todo Add phpdoc.
     */
	public function closeRoom($id) {
		$room = SupportRoom::find()->where(['id'=>$id])->one();
		$room->status = 0;
		$room->closed = time();


		if(!$room->save()) return $this->sendError('Cant close room');

		return $this->sendSuccess();
	}



    /**
     * @param \app\models\SupportRoom $room
     */
//    public function setSupportSeen(SupportRoom $room) {
//        if ($room->)
//    }
}