<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends AppController {
	// /**
	//  *
	//  */
	// public function actionTest() {
	// 	$mnx = $this->getService('Minexcoin');
	// 	var_dump($mnx->stageTransaction('XQYVZjJwvWJEvuacUQHWbi7pzTuJ3kDFrf', 0.9996));
	// }

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */

	public function actionIndex() {
		$this->layout = 'index';
		$this->view->title = 'Minexbank';

		$parkingTypes = $this->getService('ParkingType')->getTypes();

		$payouts = $this->getService('Payout')->getLastPayouts();

		return $this->render('index', compact('payouts','parkingTypes'));
	}

	public function actionAddSubscribe() {
		try {
			return $this->getService('Subscriber')->emailSubscribe();
		} catch (Exception $e) {
			return $this->sendError('System error happened');
		}
	}
}