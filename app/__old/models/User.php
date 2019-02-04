<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $address
 * @property string $verify_address
 * @property string $password
 * @property string $balance
 * @property int $status
 * @property string $created
 * @property int $twofa_enabled
 * @property int $twofa_passed
 * @property int $email_notification
 * @property string $email
 * @property string $country
 *
 * @property Notification[] $notifications
 * @property Parking[] $parkings
 * @property Payout[] $payouts
 * @property SupportMessage[] $supportMessages
 * @property SupportRoom[] $supportRooms
 * @property SupportRoom[] $supportRooms0
 */

// , \OAuth2\Storage\UserCredentialsInterface
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'user';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['status', 'created', 'twofa_enabled', 'twofa_passed', 'email_notification'], 'integer'],
			[['address', 'verify_address', 'password'], 'string', 'max' => 255],
			[['balance'], 'string', 'max' => 32],
			[['email'], 'string', 'max' => 64],
			[['country'], 'string', 'max' => 4],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'address' => 'Address',
			'verify_address' => 'Verify Address',
			'password' => 'Password',
			'balance' => 'Balance',
			'status' => 'Status',
			'created' => 'Created',
			'twofa_enabled' => '2fa Enabled',
			'twofa_passed' => '2fa Passed',
			'email_notification' => 'Email Notification',
			'email' => 'Email',
			'country' => 'Country',
			'role' => 'role',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getNotifications() {
		return $this->hasMany(Notification::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParkings() {
		return $this->hasMany(Parking::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPayouts() {
		return $this->hasMany(Payout::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSupportMessages() {
		return $this->hasMany(SupportMessage::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSupportRoomsForSupport() {
		return $this->hasMany(SupportRoom::className(), ['support_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSupportRooms() {
		return $this->hasMany(SupportRoom::className(), ['user_id' => 'id']);
	}



	/**
	 * Find user by address.
	 *
	 * @param string $address BTC address.
	 * @return static|null
	 */
	public static function findByAddress($address) {
		$user = static::find()->where(['address'=>$address])->one();
		return $user;
	}



	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return $this->password === sha1(md5($password));
	}



	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		// return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
		return static::find()->where(['id'=>$id])->one();
	}



	// /**
	//  * @inheritdoc
	//  */
	// public static function findIdentityByAccessToken($token, $type = null) {
	// 	foreach (self::$users as $user) {
	// 		if ($user['accessToken'] === $token) {
	// 			return new static($user);
	// 		}
	// 	}

	// 	return null;
	// }



	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}



	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->authKey;
	}



	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->authKey === $authKey;
	}


	/**
	 * Implemented for Oauth2 Interface
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		/** @var \filsh\yii2\oauth2server\Module $module */
		$module = Yii::$app->getModule('oauth2');
		$token = $module->getServer()->getResourceController()->getToken();
		return !empty($token['user_id'])
					? static::findIdentity($token['user_id'])
					: null;
	}

	/**
	 * Implemented for Oauth2 Interface
	 */
	public function checkUserCredentials($address, $password) {
		$user = static::findByAddress($address);
		if (empty($user)) return false;
		return $user->validatePassword($password);
	}

	/**
	 * Implemented for Oauth2 Interface
	 */
	public function getUserDetails($address)
	{
		$user = static::findByAddress($address);
		return ['user_id' => $user->getId()];
	}
}
