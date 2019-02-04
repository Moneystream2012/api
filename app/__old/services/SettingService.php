<?php

/**
 * Service worker for setting.
 */

namespace app\services;

use Yii;
use app\models\Setting;
use app\models\User;

class SettingService extends Service {
	/**
	 * Change user password.
	 *
	 * @api
	 * @return string
	 */
	public function changePassword() {
		if (!Yii::$app->request->isAjax) {
			return $this->sendError('Bad request', $code = 400);
		}

		if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
			return $this->sendError('You are not authorised');

		$user = Yii::$app->user->identity;


		if (!isset($_POST['currentPassword']) || trim($_POST['currentPassword']) === '')
			return $this->sendError('Current password not provided');

		if (sha1(md5($_POST['currentPassword'])) != $user->password)
			return $this->sendError('Current password does not match');

		if (!isset($_POST['newPassword']) || trim($_POST['newPassword']) === '')
			return $this->sendError('New password not provided');

		if (!isset($_POST['confirmPassword']) || trim($_POST['confirmPassword']) !== trim($_POST['newPassword']))
			return $this->sendError('Confirm password does not match');

		$newPassword = $_POST['newPassword'];

		if (iconv_strlen($newPassword, 'UTF-8') < 6)
			return $this->sendError('New password is too short');

		$user->password = sha1(md5($newPassword));
		
		if (!$user->save())
			return $this->sendError('Cant change password');

		return $this->sendSuccess();
	}



	/**
	 * Change user password.
	 *
	 * @api
	 * @see \app\controllers\user\SettingController::actionEmailNotificationProcess
	 * @todo Rename this method.
	 * @return string
	 */
	public function emailNotification() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
			return $this->sendError('You are not authorised');

		$user = Yii::$app->user->identity;

		$email = trim($_POST['notificationEmail']);
		$validator = new \yii\validators\EmailValidator();
		

		
		if (!$validator->validate($email, $error))
			return $this->sendError($error);

		$user->email = $email;


		if (!$user->save())
			return $this->sendError('Cant add email for notification.');

		return $this->sendSuccess();
	}

	public function emailEnableNotification() {
		if (!Yii::$app->request->isAjax)
			return $this->sendError('Bad request', $code = 400);

		if (Yii::$app->user->isGuest || Yii::$app->user->identity == null)
			return $this->sendError('You are not authorised');
		$user = Yii::$app->user->identity;

		$enableNotificationEmail = (int)$_POST['enableNotificationEmail'];
	
		$user->email_notification = $enableNotificationEmail;
		if (!$user->save())
			return $this->sendError('Cant add email for notification.');

		// var_dump($_POST['enableNotificationEmail']);
		// var_dump($user->email_notification);
		// exit;
		return $this->sendSuccess();
	}

	/**
	 * Принимает значения адресов которые надо изменитью
	 * @param type $address 
	 * @return string
	 */
	public function changeAddress($key, $value) {
		if(preg_match('/[^A-Za-z0-9]/', $value)) return $this->sendError('Invalid address');

		 
		if($this->set($key, $value)) return $this->sendSuccess($value);
		else return $this->sendError('Can`t save setting.');
	}

	/**
	 * Description
	 * @param type $propertyName 
	 * @return type
	 */
	public function get($propertyName) {
		$setting = Setting::find()->where(['k'=>$propertyName])->one();
		return $setting;
	}

	/**
	 * Description
	 * @param type $propertyName 
	 * @param type $propertyValue 
	 * @return type
	 */
	public function set($propertyName, $propertyValue) {
		$setting = $this->get($propertyName);
		if($setting !== null) {
			$setting->v = $propertyValue;
			if(!$setting->save()) return false;
			
			return true;
		};

		$setting = new Setting;
		$setting->k = $propertyName;
		$setting->v = $propertyValue;

		if(!$setting->save()) return false;

		return true;
	}
	/**
	 * Достаем все поля из бд и перепаковуем их в ассоциативный массив.
	 * @return string
	 */
	public function settingData() {
		$dataAll = Setting::find()->asArray()->all();
		$data = [];
		foreach ($dataAll as $value ) {
			$data[$value['k']] = $value['v'];

			# code...
		}
		return $data;
	}
}