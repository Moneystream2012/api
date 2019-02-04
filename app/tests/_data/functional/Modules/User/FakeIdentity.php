<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 16.10.17
 * Time: 16:20
 */
declare(strict_types=1);

namespace tests\_data\functional\Modules\User;

use App\Modules\User\Components\AppIdentityInterface;
use App\Modules\User\Components\UserModelFactory;
use yii\web\IdentityInterface;

/**
 * Class fakeIdentity
 * @package tests\functional\Modules\User
 */
class FakeIdentity implements AppIdentityInterface
{

	/**
	 * @var int|null
	 */
	private $userId = null;

	/**
	 * FakeIdentity constructor.
	 * @param int $userId
	 */
	public function __construct(int $userId) {
		$this->userId = $userId;
	}

	/**
	 * Finds an identity by the given ID.
	 * @param string|int $id the ID to be looked for
	 * @return IdentityInterface the identity object that matches the given ID.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentity($id): \yii\web\IdentityInterface {
		return new self($id);
	}

	/**
	 * Finds an identity by the given token.
	 * @param mixed $token the token to be looked for
	 * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
	 * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
	 * @return IdentityInterface the identity object that matches the given token.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentityByAccessToken($token, $type = null): ?\yii\web\IdentityInterface {
		return new self($token);
	}

	/**
	 * Returns an ID that can uniquely identify a user identity.
	 * @return string|int an ID that uniquely identifies a user identity.
	 */
	public function getId() {
		return $this->userId;
	}

	/**
	 * Returns a key that can be used to check the validity of a given identity ID.
	 *
	 * The key should be unique for each individual user, and should be persistent
	 * so that it can be used to check the validity of the user identity.
	 *
	 * The space of such keys should be big enough to defeat potential identity attacks.
	 *
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 * @return string a key that is used to check the validity of a given identity ID.
	 * @see validateAuthKey()
	 */
	public function getAuthKey(): string {
		return 'Yes!';
	}

	/**
	 * Validates the given auth key.
	 *
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 * @param string $authKey the given auth key
	 * @return bool whether the given auth key is valid.
	 * @see getAuthKey()
	 */
	public function validateAuthKey($authKey): bool {
		unset($authKey);
		return true;
	}

	public function destroySession() : bool {
		return true;
	}

	/**
	 * @return string
	 */
	public function getAddress(): string {
		/** @var \App\Modules\User\Models\UserAuthAccess $authData */
		$authData = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS)
			::find()
			->where(['userId' => $this->getId()])
			->one();
		return $authData->address;
	}


	/**
	 * @return array
	 */
	public function getUserInfo(): array {
		/** @var \App\Modules\User\Models\UserAuthAccess $authData */
		$authData = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS)
			::find()
			->where(['userId' => $this->getId()])
			->one();

		return [
			'status' => 'ok',
			'data'   => [
				'id'         => $this->getId(),
				'address'    => $authData->address,
				'permission' => []
			]
		];
	}
}