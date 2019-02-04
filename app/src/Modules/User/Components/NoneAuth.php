<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 12:37
 */
declare(strict_types=1);

namespace App\Modules\User\Components;


use yii\filters\auth\AuthMethod;
use yii\web\User;

/**
 * Class FakeAuth
 * @package app\Modules\User\Behaviors
 */
class NoneAuth extends AuthMethod
{

	/**
	 * @param User $user
	 * @param null $request
	 * @param null $response
	 * @return bool
	 */
	public function authenticate($user, $request = null, $response = null) {
		unset($user);
		unset($request);
		unset($response);
		return false;
	}
}