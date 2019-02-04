<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 31.08.17
 * Time: 15:27
 */
declare(strict_types=1);

namespace tests\_support;

use AspectMock\Proxy\Verifier;
use AspectMock\Test;
use tests\_data\functional\Modules\User\FakeIdentity;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;

trait AuthCest
{

	/**
	 * @var array
	 */
	private $token = [
		'user' => 2,
		'support' => 3,
		'admin' => 4,
	];

	/**
	 * @param \FunctionalTester $I
	 * @param string $user
	 * @param int|null $userId
	 */
	private function setUser(\FunctionalTester $I, string $user, int $userId = null): void {
		//DEPRECATED CODE!
		$this->startMockUser($this->token[$user]);
	}

	/**
	 * @var Verifier
	 */
	private $mockUser = null;

	/**
	 *
	 */
	private function startMockUser($userId) : void {
		$identity = new FakeIdentity($userId);
		\Yii::$app->user->login($identity);
		Test::double(AccessControl::class, ['beforeAction' => true]);
		$this->mockUser = Test::double(CompositeAuth::class, ['authenticate' => $identity]);
	}

	/**
	 * @param string $roleName
	 */
	protected function setUserByRole(string $roleName): void {
		$this->startMockUser($this->token[$roleName]);
	}

	private function endMockUser(): void {
		$this->mockUser->verifyInvoked('authenticate');
	}
}
