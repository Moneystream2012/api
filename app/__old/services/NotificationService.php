<?php

/**
 * Service worker for notification.
 */

namespace app\services;

use Yii;
use yii\data\Pagination;
use app\models\Notification;
use app\models\NotificationSeenIndex;
use app\models\User;

class NotificationService extends Service {
	/**
	 * Get list of notifications for specified user model.
	 *
	 * @param object $user User model.
	 */
 	public function getLastForUser() {
 		if (Yii::$app->user->isGuest)
			return $this->formErrorStatus('You are not authorised');

		$user = Yii::$app->user->identity;
		
 		$notificationQuery = Notification::find()
 			->where('user_id = 0 OR user_id = :uid',
 				[':uid'=>Yii::$app->user->identity->id])
 			->orderBy('created DESC, id DESC');
		
		$pagination = new Pagination(['totalCount' => $notificationQuery->count(), 'pageSize' => $this->itemsPerPage]);
		
		$pagination->pageSizeParam = false; // No needed, page size is defined manually.
		
		$notifications = $notificationQuery->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		$ids = array_map(function($e) {
			return $e->id;
		}, $notifications);

		$seenIds = [];
		if (count($ids) > 0) {
			$sql = 'SELECT * FROM notification_seen_index WHERE user_id = :uid AND notification_id IN ('.join(',', $ids).')';
			$seens = NotificationSeenIndex::findBySql($sql, [':uid'=>$user->id])->all();
			foreach ($seens as $s)
				$seenIds[] = $s->notification_id;
		}

		foreach ($notifications as $key => $n) {
			if (in_array($n->id, $seenIds))
				$notifications[$key]->seen = 1;
		}

 		return compact('notifications', 'pagination'); 
 	}

 	/**
	 * Get list of last parkings for specified user model through AJAX.
	 *
	 * @api
	 * @param object $user User model.
	 * @return string
	 */
	public function getLastForUserAjax(User $user) {

		if (isset($_POST['page']) && is_numeric($_POST['page']))
			$page = intval($_POST['page']);
		else
			$page = 1;

		$notificationQuery = Notification::find()
			->where('user_id = 0 OR user_id = :uid', [':uid'=>Yii::$app->user->identity->id])
			->orderBy('created DESC, id DESC');

		$pagination = new Pagination([
			'totalCount' => $notificationQuery->count(),
			'pageSize' => $this->itemsPerPage,
			'pageSizeParam' => false
		]);

		if ($page < 1) $page = 1;
		elseif ($page > $pagination->pageCount)
			$page = $pagination->pageCount;
		$pagination->setPage($page-1);


		// $notifications = $notificationQuery->offset($pagination->getOffset())
		// 	->limit($pagination->getLimit())
		// 	->asArray()->all();

		$notifications = $notificationQuery->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->asArray()->all();
// var_dump($notifications);exit();
		// Get notifications
		// $notifications =	Notification::find()
		// 	->where('user_id = 0 OR user_id = :uid', [':uid'=>Yii::$app->user->identity->id])
		// 	->orderBy('created DESC, id DESC')
		// 	->limit($pagination->getLimit())
		// 	->asArray()->all();
		// Get notification seen index
		// convert n_s_i in ([$n_s_i->id] => $n_s_i)
		$notificationsSeenIndex = NotificationSeenIndex::find()->
			where(['user_id'=>Yii::$app->user->identity->id])
			->orderBy('notification_id DESC')
			->limit(10)->all();

		$indexes = [];
		foreach ($notificationsSeenIndex as $value)
			$indexes[] = $value->notification_id;

		// foreach notifications as ...
		foreach ($notifications as &$notification) {
			$notification['created'] = date('d-m-y H:m', $notification['created']);
			$notification['seen'] = in_array($notification['id'], $indexes) ? true : false;
		}

		return $this->sendSuccess($notifications);
	}

		public function cancel() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
			return $this->sendError('You are not authorised', $code = 301);

		if (!isset($_POST['id']) || !is_numeric($_POST['id']) || intval($_POST['id']) < 1)
			return $this->sendError('Incorrect notification id');

		// $user = Yii::$app->user->identity;
		$notification = Notification::find()->where(['id'=>intval($_POST['id'])])->one();

		if ($notification == null)
			return $this->sendError('Notification not found');

		if (!$notification->delete())
			return $this->sendError('Cant delete data');

		return $this->sendSuccess();
	}



	/**
	 * Add new notification.
	 *
	 * @api
	 * @return string
	 */
	public function Add() {
		$data = Yii::$app->request->post();
		// if(isset($_GET['id']) && is_numeric($_GET['id']) )
			// $user_id = htmlspecialchars($_GET['id']);
		// var_dump($data);
		$notification = new Notification();
		$notification->title = $data['title'];
		$notification->content = $data['content'];
		$notification->user_id = $data['id'];
		$notification->created = time();
		

		if (!$notification->save()) 
			return $this->sendError('Cant add new notification.');

		return $this->sendSuccess('New notification added.');
 	}



 	/**
 	 * Set notification as seen for user.
 	 *
 	 * @api
 	 * @return string
 	 */
 	public function setAsSeen() {
 		if (Yii::$app->user->isGuest)
 			return $this->sendError('You are not authorised', $code = 301);

 		if (!isset($_POST['id']) || !is_numeric($_POST['id']) || intval($_POST['id']) < 1)
 			return $this->sendError('Notification id not provided');

 		$user = Yii::$app->user->identity;
 		$notification = Notification::findOne(intval($_POST['id']));

 		if ($notification == null)
 			return $this->sendError('Notification not found');

 		$seenRecord = NotificationSeenIndex::findOne([
 			'user_id'=>$user->id,
 			'notification_id'=>$notification->id
 		]);

 		if ($seenRecord == null) {
 			$seenRecord = new NotificationSeenIndex();
 			$seenRecord->user_id = $user->id;
 			$seenRecord->notification_id = $notification->id;
 			if (!$seenRecord->save())
 				return $this->sendError('Cant mark notification as seen');
 		}

 		return $this->sendSuccess();
 	}

 	/**
 	 * What is this?
 	 */
	// public function getLastForUser(User $user) {
	// 	return Notification::find()->where(['user_id'=>$user->id])->limit(10)->all();
	// }

	/**
	* Get list of Payouts by id
	*/
	public function getNotification(User $user){
		// $id = (int)htmlspecialchars($_REQUEST['from']);
		$notifications = Notification::find()->limit(10)->asArray()->all();
		

		
		return $this->sendSuccess($notifications);
	}


	public function notificationOfANewNtice() {
		if (Yii::$app->user->isGuest)
 			return [];

 		$user = Yii::$app->user->identity;

 		$allNotifications = Notification::find()->where('user_id = 0 OR user_id = :uid', [':uid'=>$user->id])->count();
 		$allSeenNotification = NotificationSeenIndex::find()->where('user_id = :uid', [':uid'=>$user->id])->count();
 		$notSeenNotification = $allNotifications - $allSeenNotification;
 		$data = [
 		'allNotifications'=>$allNotifications,
 		'allSeenNotification'=>$allSeenNotification,
 		'notSeenNotification'=>$notSeenNotification

 		];
 		// var_dump($allNotifications);exit();
 		return $data;
	}
}