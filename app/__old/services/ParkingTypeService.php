<?php

namespace app\services;

use Yii;
use app\models\ParkingType;

/**
 * Service worker for parking type.
 */
class ParkingTypeService extends Service {
	/** @var array $_cache List of fetched types. */
	private $_cache = [];

	/** @var boolean $_cached If here are fetched types. */
	private $_cached = false;

	
	
	/**
	 * Find one by parameter.
	 *
	 * @author Vladyslav Zaichuk <xinonghost@gmail.com>
	 * @param array $params Array of params.
	 * @return object|null
	 */
	public function find($params) {
		return ParkingType::find()->where($params)->one();
	}

	
	
	public function add() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		$a = $this->checkPostParkingType($_POST['title'],  $_POST['rate'], $_POST['period']);
		$title = $a['title'];
		$rate = $a['rate'];
		$period = $a['period'];
		
		if(count($a['errors']) === 0){
			$parkingType = new ParkingType();
			
			$parkingType->title = $title;
			$parkingType->rate = $rate . "";
			$parkingType->period = ($period * 3600 * 24);
			$parkingType->created = time();

			if (!$parkingType->save())
				return $this->sendError('Cant save data');
			
			return $this->sendSuccess("operation success");
		}
		else{
			return $this->sendError(implode(",",$a['errors']));
		}
	}
	
	
	
	public function edit() {
		// return $this->sendSuccess('operation success');
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);
		$errors = [];

		$rate = htmlspecialchars($_POST['rate']);

		is_numeric($rate) ? $rate = floatval($rate) : array_push($errors, 'rate must be numeric.');
		$rate > 0 ?: array_push($errors, "Rates must be more than 0.");
		
		if(count($errors) === 0){
			$parkingType = ParkingType::find()->where(['id' => (int)$_POST['id']])->one();
			
			// $parkingType->title = $title;
			$parkingType->rate = (string)$rate;
			// $parkingType->period = ($period * 3600 * 24);
			// $parkingType->created = time();
			if (!$parkingType->save())
				return $this->sendError('Cant save data');
			
			return $this->sendSuccess($parkingType->title.' rate changed.');
		}
		else{
			return $this->sendError(implode(',',$errors));
		}
	}
	
	
	
	public function getTypeById() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);
		
		$id = (int)$_POST['id'];
		if ($id < 0)
			return $this->sendError('Type id must be more than 0');
		
		$parkingType = ParkingType::find()->where(['id' => $id])->one();
		$parkingType->period = $parkingType->period / 86400; 
		$parkingType->rate = floatval($parkingType->rate);
		
		return $this->sendSuccess(['title' => $parkingType->title,
									'rate' => $parkingType->rate,
									'period' => $parkingType->period]);
	}
	
	
	
	public function getTypeTitleById($id) {
		$parkingType = ParkingType::find()->where(['id' => $id])->one();
		return $parkingType->title;
	}
	
	
	
	public function getTypes() {
		return ParkingType::find()->all();
	}

	
	
	/**
	 * Get raw post
	 * and validate them.
	 * @return array
	 */
	private function checkPostParkingType($title , $rate, $period) {
		$title = (string) htmlspecialchars($title);
		$rate = htmlspecialchars($rate);
		$period = htmlspecialchars($period);

		$errors = []; //array of string's with errors
		preg_match("/^[A-Za-z ]+$/", $title) ?: array_push($errors, "Parking name contains invalid characters.");
		is_numeric($rate) ? $rate = floatval($rate) : array_push($errors, "rate must be numeric.");
		strlen($title) > 3 ?: array_push($errors, "Parking name too short.");
		$rate > 0 ?: array_push($errors, "Rates must be more than 0.");
		$period >= 1 ?: array_push($errors, "period must be more than 1.");
		
		return ['title' => $title, 'rate' => $rate, 'period' => $period, 'errors' => $errors];
	}



	/**
	 * Get types mapped as id => object.
	 *
	 * @return array
	 */
	public function getTypesMapped() {
		$types = ParkingType::find()->all();

		$map = [];

		if (count($types) > 0) {
			foreach ($types as $type)
				$map[$type->id] = $type;
		}

		return $map;
	}



	/**
	 * Get from cache.
	 *
	 * @param int $id Parking type identifier.
	 * @return object|null
	 */
	public function getFromCache($id = 0) {
		if (!$this->_cached) {
			$this->_cache = $this->getTypesMapped();
			$this->_cached = true;
		}

		return isset($this->_cache[$id]) ? $this->_cache[$id] : null;
	}
	
	
	
	/**
	 * Method for api
	 *
	 * @api
	 */
	public function getParkingTypes(){
		$parkingTypes = $this->getTypes();
		$response = [];
		foreach ($parkingTypes as $parkingType)
			$response[$parkingType->title] = $parkingType->rate;

		return $this->sendSuccess($response);
	}
}