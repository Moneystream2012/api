<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AppController;

/**
 * Controller for user's setting.
 */
class SettingController extends AppController {
	/**
	 * Displays setting for user.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (Yii::$app->user->isGuest)
			return $this->goHome();

		$this->view->title = 'Setting';

		$setting = $this->getService('Setting');

		$data = $setting->settingData();

		try {
			return $this->render('setting', compact('data'));
		} catch (Exception $e) {
			exit('Error: Something went wrong');
		}
	}

	/**
	 * Принимает имя и значение адреса , проверяется если адрес, правильный ли он. Передается в сервис дальше.
	 * @return string
	 */
	public function actionChangePayoutServerAddress() {
		if(!isset($_POST['newPayoutAddress'])) $this->sendError('Address not found');
		$this->getService('Setting')->changeAddress('payout_server_address', $_POST['newPayoutAddress']);

		 // return $this->sendSuccess();
	}

	/**
	 * Принимает имя и значение адреса , проверяется если адрес, правильный ли он. Передается в сервис дальше.
	 * @return string
	 */
	public function actionChangeBankChangeAddress() {
		if(!isset($_POST['newBankChangeAddress'])) $this->sendError('Address not found');
		$name = 'bank_change_address';
		$this->getService('Setting')->changeAddress($name, $_POST['newBankChangeAddress']);

		 // return $this->sendSuccess();
	}

	/**
	 * Принимает имя и значение часла , проверяется если часло, правильное ли он. Передается в сервис дальше.
	 * @return string
	 */
	public function actionChangeQuantityStringsCron() {
		if(!isset($_POST['newQuantityStringsCron'])) $this->sendError('Quantity not found');
		if(preg_match('/[^0-9]/', $_POST['newQuantityStringsCron']) || $_POST['newQuantityStringsCron'] >100 ) return $this->sendError('Invalid quantity');

		$name = 'quantity_strings_cron';
		$this->getService('Setting')->changeAddress($name, $_POST['newQuantityStringsCron']);

		 // return $this->sendSuccess();
	}
}