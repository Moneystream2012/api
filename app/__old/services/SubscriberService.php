<?php

namespace app\services;

use Yii;
use yii\data\Pagination;
use app\models\Subscriber;

class SubscriberService extends Service {
	
	public function getAllWithPagination(){
		$subscribersQuery = Subscriber::find()->orderBy('created DESC');
		
		$pagination = new Pagination(['totalCount' => $subscribersQuery->count(), 'pageSize' => $this->itemsPerPage]);
		
		$pagination->pageSizeParam = false;
		
		$subscribers = $subscribersQuery->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
		
		return compact('subscribers', 'pagination');
	}

	public function emailSubscribe() {
		// if (!Yii::$app->request->isAjax)
		// 	return $this->sendError('Bad request', $code = 400);

		// if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
		// 	return $this->sendError('You are not authorised');

		// $user = Yii::$app->user->identity;

		$email = trim($_POST['emailSubscribe']);
		// var_dump($email);exit;
		$validator = new \yii\validators\EmailValidator();
		
		
		if (!$validator->validate($email, $error))
			return $this->sendError($error);

		$subscribe = new Subscriber();
		$subscribe->email = $email;
		$subscribe->created = time();


		if (!$subscribe->save())
			return $this->sendError('Cant add email for notification.');

		return $this->sendSuccess();
	}
}