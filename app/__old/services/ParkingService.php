<?php

namespace app\services;

use Yii;
use yii\data\Pagination;
use app\models\Parking;
use app\models\User;
use app\models\ParkingType;

/**
 * Service worker for parking.
 */
class ParkingService extends Service {
	/** @var float $_minimalReturn Minimal return value must be for parking. */
	private $_minimalReturn = 0.001;



	/**
	 * Verify if all data are pass the requirements.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return array
	 */
	public function validateData() {
		if (Yii::$app->user->isGuest)
			return $this->formErrorStatus('You are not authorised');

		$user = Yii::$app->user->identity;

		if (!isset($_POST['amount']) || !is_numeric($_POST['amount']) || floatval($_POST['amount']) <= 0)
			return $this->formErrorStatus('Amount must be greater than zero');
		if (!isset($_POST['type']) || !is_numeric($_POST['type']) || intval($_POST['type']) < 1)
			return $this->formErrorStatus('Type id is wrong');

		$typeId = intval($_POST['type']);
		$type = $this->getService('ParkingType')->find('id = '.$typeId);
		if ($type == null)
			return $this->formErrorStatus('Type not found');

		// If user typed amount with comma, replace it to dot.
		$amount = str_replace(',', '.', $_POST['amount']);
		// Get real float value.
		$amount = floatval($amount);

		$balanceData = $this->getService('User')->syncBalance();
		if ($balanceData['status'] == 0)
			return $balanceData;

		$availableData = $this->getInfo($user);

		if (round($amount, 8) > round($availableData['available'], 8))
			return $this->formErrorStatus('Not enought coins');

		$responseArray = [
			'type_id'=>$type->id,
			'user_id'=>$user->id,
			'rate'=>$type->rate,
			'amount'=>$amount,
			'period'=>$type->period
		];
		return $this->formSuccessStatus($responseArray);
	}


	/**
	 * Verify data and add new parking.
	 *
	 * @api
	 * @uses ParkingService::validateData
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return string
	 */
	public function addByAjax() {
		if (Yii::$app->user->isGuest)
			return $this->sendError('You are not authorised', $code = 301);
		
		$user = Yii::$app->user->identity;

		$validationData = $this->validateData();
		if ($validationData['status'] == 0)
			return $this->sendError($validationData['error']);

		$period = time() + ($validationData['data']['period'] * 3600 * 24);

		$parking = new Parking();
		$parking->user_id = $user->id;
		$parking->type_id = $validationData['data']['type_id'];
		$parking->rate = (string)$validationData['data']['rate'];;
		$parking->amount = (string)round($validationData['data']['amount'], 8, PHP_ROUND_HALF_DOWN);
		$parking->return_amount = (string)round($parking->amount * ($parking->rate / 100), 8, PHP_ROUND_HALF_DOWN);
		$parking->info = '';
		$parking->status = 1;
		$parking->created = time();
		$parking->expired = $period;
		$parking->device = 'web';
		$parking->payout_prepared = 0;

		// If return smaller than minimal value.
		if ($parking->return_amount < $this->_minimalReturn)
			return $this->sendError('Your return is smaller than minimal value required: '.$this->_minimalReturn);

		if (!$parking->save())
			return $this->sendError('Cant save data');

		return $this->sendSuccess();
	}
	/**
	 * Verify if all data are pass the requirements.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return array
	 */
	public function validateDataApi(User $user) {
		if (!isset($_POST['amount']) || !is_numeric($_POST['amount']) || floatval($_POST['amount']) <= 0)
			return $this->formErrorStatus('Amount must be greater than zero');
		if (!isset($_POST['type']) || !is_numeric($_POST['type']) || intval($_POST['type']) < 1)
			return $this->formErrorStatus('Type id is wrong');

		$typeId = intval($_POST['type']);
		$type = $this->getService('ParkingType')->find('id = '.$typeId);
		if ($type == null)
			return $this->formErrorStatus('Type not found');

		// If user typed amount with comma, replace it to dot.
		$amount = str_replace(',', '.', $_POST['amount']);
		// Get real float value.
		$amount = floatval($amount);


		// $balanceData = $this->getService('User')->syncBalanceApi($user);
		// if ($balanceData['status'] == 0)
		// 	return $balanceData;
		// $balanceData['data'] = 100000;  

		$activeSum = Parking::find()->where(['user_id'=>$user->id, 'status'=>1])->sum('amount');
		$activeSum = $activeSum > 0 ? $activeSum : 0;
		if ($amount > ($user->balance - $activeSum))
			return $this->formErrorStatus('Not enought coins');

		$responseArray = [
			'type_id'=>$type->id,
			'user_id'=>$user->id,
			'rate'=>$type->rate,
			'amount'=>$amount,
			'period'=>$type->period
		];
		return $this->formSuccessStatus($responseArray);
	}

		/**
	 * Verify data and add new parking.
	 *
	 * @api
	 * @uses ParkingService::validateData
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return string
	 */
	public function addByApi(User $user) {

		$validationData = $this->validateDataApi($user);
		if ($validationData['status'] == 0)
			return $this->sendError($validationData['error']);

		$period = time() + 60 * 3;// + ($validationData['data']['period'] * 3600 * 24);

		$parking = new Parking();
		$parking->user_id = $user->id;
		$parking->type_id = $validationData['data']['type_id'];
		$parking->rate = (string)$validationData['data']['rate'];;
		$parking->amount = (string)round($validationData['data']['amount'], 8, PHP_ROUND_HALF_DOWN);
		$parking->return_amount = (string)round($parking->amount * ($parking->rate / 100), 8, PHP_ROUND_HALF_DOWN);
		$parking->info = '';
		$parking->status = 1;
		$parking->created = time();
		$parking->expired = $period;
		$parking->device = 'web';
		$parking->payout_prepared = 0;

		// If return smaller than minimal value.
		if ($parking->return_amount < $this->_minimalReturn)
			return $this->sendError('Your return is smaller than minimal value required: '.$this->_minimalReturn);

		if (!$parking->save())
			return $this->sendError('Cant save data');

		return $this->sendSuccess();
	}



	/**
	 * Get list of last parkings for specified user model.
	 *
	 * @param \app\models\User $user
	 * @param int $status
	 * @param int $limit
	 * @return \app\models\Parking[]
	 */
	public function getLastForUser(User $user, $status = null, $limit = 10) {
		$queryParamsArray = ['user_id' => $user->id];

		if (isset($_GET['status']) && in_array(intval($_GET['status']), range(0, 2)))
			$queryParamsArray['status'] = intval($_GET['status']);

		if ($status !== null && in_array($status, range(0, 2)))
			$queryParamsArray['status'] = $status;

		return Parking::find()->where($queryParamsArray)
			->andWhere('expired > '.(time()+5))
			->orderBy('created DESC, id DESC')->limit($limit)->all();
	}



	/**
	 * Get list of last parkings for specified user model through AJAX.
	 *
	 * @api
	 * @param object $user User model.
	 * @param int $limit Limit query.
	 * @return string
	 */
	public function getLastActiveForUserAjax(User $user, $limit = 10) {
		$parkings = Parking::find()
			->where(['user_id'=>$user->id, 'status'=>1])
			->andWhere('expired > '.(time()+5))
			->orderBy('created DESC, id DESC')
			->limit($limit)->asArray()->all();

		if (count($parkings) > 0) {
			foreach ($parkings as $key => $value)
				$parkings[$key] = $this->formParkingView($value);
		}

		return $this->sendSuccess($parkings);
	}



	/**
	 * Form parking element for view.
	 *
	 * @param object $parking
	 * @return array
	 */
	public function formParkingView($parking) {
		$parking['cancel'] = $this->canBeCanceled($parking);
		$parking['created'] = $this->formatDate((int)$parking['created']);
		$parking['expired'] = $this->determineTimerValue($parking);
		$parking['status'] = $this->getStatusAsString($parking['status']);
		
		$parkingType = $this->getService('ParkingType')->getFromCache($parking['type_id']);
		$parking['type'] = $parkingType ? $parkingType->title : 'Undefined';

		return $parking;
	}



	/**
	 * Determine final expired timer value.
	 *
	 * @param int $remainTime
	 * @return string
	 */
	public function determineTimerValue($parking) {
		if ($parking['status'] == 0)
			return '-';

		if ($parking['status'] == 2)
			return $this->formatDate($parking['expired']);

		$remainTime = $parking['expired']-time();
		// 0:00:00
		if ($remainTime <= 0)
			return 'Pending';

		$days = floor($remainTime / (3600 * 24));
		$remainTime -= $days * (3600 * 24);

		$hours = floor($remainTime / (3600));
		$remainTime -= $hours * 3600;

		$minutes = floor($remainTime / 60);
		
		return $days.':'.str_pad($hours, 2, '0', STR_PAD_LEFT).':'.str_pad($minutes, 2, '0', STR_PAD_LEFT);
	}



	/**
	 * Format created time.
	 *
	 * @param int $timestamp
	 * @return string
	 */
	public function formatDate($timestamp) {
		return date('d.m.y H:i',$timestamp);
	}



	/**
	 * Get statistic of user actives.
	 *
	 * @param object $user
	 * @return array
	 */
	public function getInfo(User $user = null) {
		if (!$user) $user = Yii::$app->user->identity;

		$parked = Parking::find()->where(['user_id'=>$user->id, 'status'=>1])->sum('amount');
		if (!$parked) $parked = 0;

		$available = $user->balance - $parked;
		if ($available < 0) $available = 0;

		return compact('parked', 'available');
	}



	/**
	 * Get list for user via AJAX.
	 *
	 * @api
	 * @return string
	 */
	public function getListForUserAjax() {
		if (Yii::$app->user->getIsGuest())
			return $this->sendError('You are not authorised', $statusCode = 301);

		if (isset($_POST['page']) && is_numeric($_POST['page']))
			$page = intval($_POST['page']);
		else
			$page = 1;

		$user = Yii::$app->user->identity;
		$queryParamsArray = ['user_id'=>$user->id];

		if (isset($_REQUEST['status']) && in_array(intval($_REQUEST['status']), range(0, 2)))
			$queryParamsArray['status'] = intval($_REQUEST['status']);

		$parkingQuery = Parking::find()
			->where($queryParamsArray)
			->orderBy('created DESC, id DESC');

		$pagination = new Pagination([
			'totalCount' => $parkingQuery->count(),
			'pageSize' => $this->itemsPerPage,
			'pageSizeParam' => false
		]);

		if ($page < 1) $page = 1;
		elseif ($page > $pagination->pageCount)
			$page = $pagination->pageCount;
		$pagination->setPage($page-1);

		$parkings = $parkingQuery->offset($pagination->getOffset())
			->limit($pagination->getLimit())->asArray()->all();

		if (count($parkings) > 0) {
			foreach ($parkings as $key => $value)
				$parkings[$key] = $this->formParkingView($value);
		}

		return $this->sendSuccess($parkings);
	}



	/**
	 * Get amount of parkings by status.
	 *
	 * @param object $user
	 * @return array
	 */
	public function getAmountOfParkings(User $user = null) {
		if (!$user) {
			$allParkings = Parking::find();
			$cancelParkings = Parking::find()->where(['status'=>0]);
			$activeParkings = Parking::find()->where(['status'=>1]);
			$completedParkings = Parking::find()->where(['status'=>2]);
		} else {
			$allParkings = Parking::find()->where(['user_id'=>$user->id]);
			$cancelParkings = Parking::find()->where(['user_id'=>$user->id,'status'=>0]);
			$activeParkings = Parking::find()->where(['user_id'=>$user->id,'status'=>1]);
			$completedParkings = Parking::find()->where(['user_id'=>$user->id,'status'=>2]);
		}
		
		$allParkings		= $allParkings->count();
		$cancelParkings		= $cancelParkings->count();
		$activeParkings		= $activeParkings->count();
		$completedParkings	= $completedParkings->count();
		
		return compact('allParkings','cancelParkings','activeParkings','completedParkings');
	}



	/**
	 * Get list of parkings for user.
	 *
	 * @api
	 * @param object $user
	 * @return array
	 */
	public function getParkingsForUser(User $user){
		$params = ['user_id'=>$user->id];

		$from = isset($_POST['from']) && intval($_POST['from']) > 0 ? intval($_POST['from']) : -1;
		$statuses = ['canceled' => 0,'active' => 1,'completed' => 2];

		if (isset($_POST['filter']) && isset($statuses[$_POST['filter']]))
			$params['status'] = $statuses[$_POST['filter']];

		$parkingsQuery = Parking::find()->where($params);

		if ($from > 0) $parkingsQuery->andWhere(['<', 'id', $from]);

		$parkings = $parkingsQuery->limit(10)->orderBy('created DESC, id DESC')->asArray()->all();

		return $this->sendSuccess($parkings);
	}



	/**
	 * Get list of parkings for specified user model and paginator.
	 *
	 * @author Vladislav Zaichuk <xinonghost@gmail.com>
	 * @return array
	 */
	public function getExtendedParkingsWithPagination() {
		$parkingQuery = Parking::find();

		if (isset($_GET['status']) && in_array(intval($_GET['status']), range(0, 2)))
			$parkingQuery->where(['status'=>intval($_GET['status'])]);

		$parkingQuery->orderBy('expired ASC, id DESC');
		$pagination = new Pagination([
			'totalCount' => $parkingQuery->count(),
			'pageSize' => $this->itemsPerPage,
			'pageSizeParam' => false
		]);
		
		$parkings = $parkingQuery->offset($pagination->offset)
			->limit($pagination->limit)->all();

		$usersRaw = User::find()->where(['status'=>1])->all();
		$models = [];
		$users = [];
		foreach ($usersRaw as $user) $users[$user->id] = $user;

		foreach ($parkings as $parking) {
			$parkingType = $this->getService('ParkingType')->getFromCache($parking['type_id']);
			$type = $parkingType ? $parkingType->title : 'Undefined';

			$models[] = [
				'userId'=>$parking->user_id,
				'parkingId'=>$parking->id,
				'address'=>$users[$parking->user_id]['address'],
				'created'=>$parking->created,
				'expired'=>$parking->expired,
				'type'=>$type,
				'balance'=>(float)$users[$parking->user_id]['balance'],
				'amount'=>$parking->amount
			];
		}

		return compact('models', 'pagination');
	}



	/**
	 * Get information abount debts.
	 *
	 * @return array
	 */
	public function getDebts() {
		$parkingTypes = $this->getService('ParkingType')->getTypes();
		$debts = [];

		foreach ($parkingTypes as $type) {
			$sum = Parking::find()
				->where(['type_id'=>$type->id, 'status'=>1])
				->sum('return_amount');
			$debts[] = ['type'=>$type, 'sum'=>$sum];
		}
		
		return $debts;
	}



	/**
	 * Get statistic of what parking types and debts.
	 *
	 * @todo Determine what the method is.
	 * @return array
	 */
	public function getStatistic() {
		$sumTypes = $this->getDebts();
		
		$parkingType = $this->getService('ParkingType')->getTypes();
		$parkingTotal = Parking::find()->sum('return_amount');

		return compact('parkingType', 'parkingTotal', 'sumTypes');
	}



	/**
	 * Description
	 *
	 * @return type
	 */
	public function sendEmail() {
		// $user = Yii::$app->user->identity;
		Yii::$app->mailer->compose('contact/html')
		->setFrom('minexbank@l.minexbank')
		->setTo(Yii::$app->user->identity->email)
		->setSubJect('Add new parking')
		->setTextBody('Thx for add new park!')
		->setHtmlBody('<b>Time final parking:'.' 123123123'.'</b>')
		->send();
	}



	/**
	 * Cancel parking and delete model.
	 *
	 * @api
	 * @author Vlad Babin <Vlad_babin_2013@mail.ru>
	 * @return string
	 */
	public function cancel() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest)
			return $this->sendError('You are not authorised', $code = 301);

		if (!isset($_POST['id']) || !is_numeric($_POST['id']) || intval($_POST['id']) < 1)
			return $this->sendError('Incorrect parking id');

		$user = Yii::$app->user->identity;
		$parking = Parking::find()->where(['id'=>intval($_POST['id']), 'user_id'=>$user->id])->one();

		if ($parking == null)
			return $this->sendError('Parking not found');

		if (!$this->canBeCanceled($parking))
			return $this->sendError('You cant cancel the parking');

		$parking->status = 0;

		if (!$parking->save())
			return $this->sendError('Cant cancel parking');

		return $this->sendSuccess();
	}


	/**
	 * Description
	 *
	 * @param User $user User object.
	 * @return array
	 */
	public function getAllForUser(User $user) {
		if (!isset($_GET['status']) || intval($_GET['status']) > 2 || intval($_GET['status']) < 0)
			$parkingQuery = Parking::find()->where(['user_id' => $user->id])->orderBy('created DESC');
		else
			$parkingQuery = Parking::find()->where(['user_id' => $user->id,'status'=> intval($_GET['status']) ])->orderBy('created DESC');
		
		$pages = new Pagination([
			'totalCount' => $parkingQuery->count(),
			'pageSize' => $this->itemsPerPage,
			'pageSizeParam' => false
		]);

		$parkings = $parkingQuery->offset($pages->offset)
			->limit($pages->limit)
			->all();

		return compact('parkings', 'pages');
	}



	/**
	 * Get status of parking as string.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param int $status Value of status param.
	 * @return string
	 */
	public function getStatusAsString($status) {
		$availableStatuses = [0=>'Canceled', 1=>'Active', 2=>'Completed'];

		if (!isset($availableStatuses[$status]))
			return 'Undefined';

		return $availableStatuses[$status];
	}



	/**
	 * Check if parking can be canceled.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param int $status Status value of parking.
	 * @return boolean
	 */
	public function canBeCanceled($parking) {
		return $parking['status'] == 1 && $parking['expired'] > time();
	}



	/**
	 * Check if parking can be restarted.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param int $status Status value of parking.
	 * @return boolean
	 */
	public function canBeRestarted($status) {
		if ($status == 0) return true;
		return false;
	}



	/**
	 * Get some number of active parking without prepared transaction.
	 *
	 * @param int $limit
	 * @return Parking[]
	 */
	public function getActiveParkingsWithNotPreparedPayoutTx($limit = 1) {
		return Parking::find()
			->where(['payout_prepared'=>0, 'status'=>1])
			->andWhere(['<', 'created + round((expired-created)/2)', time()])
			->orderBy('created + round((expired-created)/2)')
			->limit($limit)->all();
	}



	/**
	 * Get some number of active parking with prepared transaction.
	 *
	 * @param int $limit
	 * @return Parking[]
	 */
	public function getActiveParkingsWithPreparedPayoutTx($limit = 1) {
		return Parking::find()
			->where(['payout_prepared'=>1, 'status'=>1])
			->andWhere(['<', 'expired', time()])
			->orderBy('expired')->limit($limit)->all();
	}
}