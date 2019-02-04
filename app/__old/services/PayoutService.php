<?php

namespace app\services;

use Yii;
use app\models\Payout;
use app\models\User;
use yii\data\Pagination;

/**
 * Service worker for payout.
 *
 * @property int $itemsPerPage Amount of items per page.
 * @package app\services
 */
class PayoutService extends Service {
	/**
	 * Get list of payouts for specified user model.
	 *
	 * @param object $user User model.
	 */
	public function getLastForUser(User $user) {
		return Payout::find()->where(['user_id'=>$user->id])
			->orderBy('created DESC')
			->limit(10)
			->all();
	}



	/**
	 * Get list of last payouts.
	 *
	 * @param int $limit
	 * @return \app\models\Payout[]
	 */
	public function getLastPayouts($limit = 6) {
		return Payout::find()->orderBy('created DESC')->limit($limit)->all();
	}



	/**
	 * Get all payouts for user and generate paginator.
	 *
	 * @param object $user User model.
	 * @return array
	 */
	public function getAllForUser(User $user) {
		// выполняем запрос
		$payoutQuery = Payout::find()->where(['user_id' => $user->id])->orderBy('created DESC, id DESC');
		
		// подключаем класс Pagination
		$pages = new Pagination([
				'totalCount' => $payoutQuery->count(),
				'pageSize' => $this->itemsPerPage
			]);
		
		// приводим параметры в ссылке к ЧПУ
		$pages->pageSizeParam = false;
		$payouts = $payoutQuery->offset($pages->offset)
			->limit($pages->limit)
			->all();

		return compact('payouts', 'pages');
	}


	/**
	 * Выводим список всех выплат по системе с пагинацией.
     *
	 * @return array
	 */
	public function getAllForAllUsers() {
	    /** @var \yii\db\ActiveQuery $payoutQuery */
        $payoutQuery = Payout::find()->orderBy('created DESC');

        /** @var \yii\data\Pagination $pagination */
		$pagination = new Pagination([
			'totalCount' => $payoutQuery->count(),
			'pageSize' => $this->itemsPerPage,
			'pageSizeParam' => false
		]);

        /** @var \app\models\Payout $payouts */
		$payouts = $payoutQuery->offset($pagination->offset)->limit($pagination->limit)->all();

		return compact('payouts', 'pagination');
	}



	/**
	 * Get last for user per AJAX.
	 *
	 * @api
	 * @return string
	 */
	public function getLastAjax() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest)
			return $this->sendError('You are not authorised', $code = 301);

		$payouts = $this->getLastForUser(Yii::$app->user->identity);

		$payouts = array_map(function($e) {
			return [
				'id'		=>$e->transaction_id,
				'created'	=>date('d.m.y H:i', (int)$e->created),
				'profit'	=>$e->amount
			];
		}, $payouts);

		return $this->sendSuccess($payouts);
	}
	
	
	
	/**
	 * Get certain page for user per AJAX.
	 *
	 * @api
	 * @return string
	 */
	public function getCertainAjax($page = 1) {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest)
			return $this->sendError('You are not authorised', $code = 301);
		
		$user = Yii::$app->user->identity;
		
		// Check page parameter
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$page = (int) htmlspecialchars($_POST['page']);
		if(!is_numeric($page))
			return $this->sendError('Bad page number');
		
		
		// Make request with pagination
		$payoutQuery = Payout::find()->where(['user_id'=>$user->id])->orderBy('created DESC, id DESC');
		
		// подключаем класс Pagination
		$pages = new Pagination([
				'totalCount' => $payoutQuery->count(),
				'pageSize' => 10
			]);
			
		$offset = (($page-1) * $this->itemsPerPage);
		
		// приводим параметры в ссылке к ЧПУ
		$pages->pageSizeParam = false;
		$payouts = $payoutQuery->offset($offset)
			->limit($pages->limit)
			->all();

		$payouts = array_map(function($e) {
			return [
				'id'		=>$e->transaction_id,
				'created'	=>date('d.m.y H:i', (int)$e->created),
				'profit'	=>$e->amount
			];
		}, $payouts);

		return $this->sendSuccess($payouts);
	}
	
	
	/**
	* Get list of Payouts by id
	*
	* @todo Rename method to 'getByRequestId'.
	*/
	public function getPayoutsById(User $user){
		$id = (int)htmlspecialchars($_REQUEST['from']);
		$payouts = Payout::find()->where(['user_id'=>$user->id])->andWhere(['>=', 'id', $id])->limit(10)->all();
		
		$response = [];
		foreach($payouts as $k => $payout){
			$response[] = [
			'id' => $payout->id,
			'type' => $this->getService('ParkingType')->getTypeTitleById($user->id),
			'transaction_id' => $payout->transaction_id,
			'user_id' => $payout->user_id,
			'amount' => $payout->amount,
			'created' => $payout->created
			];
		}
		
		return $this->sendSuccess($response);
	}



	/**
	 * Add new payout.
	 *
	 * @return object|null
	 */
	public function add($parkingId, $txid, $userId, $amount) {
		$exists = Payout::find()
			->where('parking_id = :pid OR transaction_id = :tid', [':pid'=>$parkingId, ':tid'=>$txid])
			->one();
		if ($exists)
			return null;

		$model = new Payout();
		$model->parking_id = $parkingId;
		$model->transaction_id = $txid;
		$model->user_id = $userId;
		$model->amount = $amount;
		$model->created = time();

		return $model->save() ? $model : null;
	}
}