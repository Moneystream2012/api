<?php

/**
 * Service worker for user.
 */

namespace app\services;

use Yii;
// use yii\data\Pagination;
// use app\models\User;
// use Google\Authenticator\GoogleAuthenticator;
use app\models\Parking;
use app\models\Payout;
use app\models\User;

class BitcoinService extends Service {


	/**
	 * Description
	 * @author Alexandr Parkhomneko <mrsadrek@gmail.com>
	 * @param type $address 
	 * @return type
	 */
	public function getBalance($address) {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'https://blockchain.info/rawaddr/'.$address);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = curl_exec($curl);

		if (curl_errno($curl))
			return $this->formErrorStatus(curl_error($curl));

		curl_close($curl);

		$result = @json_decode($response, true);

		if ($result == null)
			return $this->formErrorStatus('Wrong response');

		if (!isset($result["final_balance"]))
			return $this->formErrorStatus('Balance not found');

		$balance = (string)$result["final_balance"] / 100000000;

		return $this->formSuccessStatus($balance);
	}


	// public function checkParking() {
	// 	$getParkings = Parking::find()->where(['status'=>1])->all();
	// 	foreach($getParkings as $parking) {
	// 		if( $parking->expired > time() ) {
	// 			$payout = new Payout();
	// 			$payout->parking_id = $parking->id;
	// 			$payout->transaction_id = (string)1;
	// 			$payout->user_id = $parking->user_id;
	// 			$payout->amount = (string)($parking->amount * ($parking->rate/100+1));
	// 			$payout->created = time();
	// 			$parking->status = (string)2;
			
	// 			if($payout->save()) {
	// 				$user = User::find()->where(['id'=>$payout->user_id])->one();
	// 				$user->balance =  (string)($user->balance + $payout->amount);
	// 			} else {
	// 				return $this->sendError('Cant add amount to user balance.');
	// 			}

	// 			if (!$payout->save() || !$parking->save() || !$user->save()){
	// 		 	// 	var_dump($payout->getErrors());
	// 				// var_dump($user->getErrors());
	// 				// var_dump($parking->getErrors());


	// 				return $this->sendError('Cant add new payout.');
	// 			} else { }
	// 		}
	// 	}	
	// }


}