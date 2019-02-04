<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);


namespace App\Modules\User\Components;

use App\Modules\User\Models\User;
use App\Modules\User\Models\UserAuthAccess;
use App\Modules\User\Modules\JWT\JWTIdentity;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\Application;
use yii\web\Request;
use yii\web\UnauthorizedHttpException;

/**
 * Class WebUser
 * @package App\Modules\User\Components
 */
class WebUser extends \yii\web\User
{
	/**
	 *
	 */
	public function sendUserData() {
		/* @var JWTIdentity $id */
		$id = $this->getIdentity();
		\Yii::$app->response->data = $id->getUserInfo();
	}

	/**
	 * Returns a user address.
	 * @return string the unique identifier for the user. If `null`, it means the user is a guest.
	 * @see getIdentity()
	 */
	public function getAddress(): ?string {
		/* @var JWTIdentity $identity */
		$identity = $this->getIdentity();

		return $identity !== null ? $identity->getAddress() : null;
	}

	public function loginRequired($checkAjax = true, $checkAcceptHeader = true): void {
		throw new UnauthorizedHttpException(\Yii::t('yii', 'Login Required'));
	}
}