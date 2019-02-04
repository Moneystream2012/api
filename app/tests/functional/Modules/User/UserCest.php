<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.10.17
 * Time: 11:56
 */
declare(strict_types=1);

namespace tests\functional\Modules\User;

use App\Components\Amqp\AmqpRPCClient;
use AspectMock\Test;
use tests\_support\AuthCest;
use tests\_support\AuthCestInterface;
use tests\fixtures\User\UserAuthAccessFixture;
use tests\fixtures\User\UserAuthAssignmentFixture;

/**
 * Class UserCest
 * @package tests\functional\Modules\User
 */
class UserCest implements AuthCestInterface
{

	use AuthCest;

	public function _fixtures(): array {
		return [
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class
		];
	}

	/**
	 *
	 */
	public function getIndex(\FunctionalTester $I): void {
		Test::double(AmqpRPCClient::class, ['createRequest' => 0]);

		$this->startMockUser(self::ADMIN_ID);
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl('user/user/index'));
		$I->canSeeResponseContainsJson([
			[
				'id'             => 1,
				'username'       => 'fooBarBaz',
				'active'         => 1,
				'notification'   => 0,
				'email'          => 'fooBarBaz@localhost.local',
				'phone'          => '+3000000000',
				'countryCode'    => '',
				'moderatorId'    => 1,
				'auth'           => [
					'id'                => 1,
					'address'           => 'foobarfoobarfoobarfoobar',
					'tfauthActive'      => 0,
					'tfauthCode'        => '',
					'userId'            => 1,
					'resetToken'        => '',
				],
				'balance'        => 0,
				'parkingBalance' => 0
			]
		]);

		$this->endMockUser();
		Test::clean();
	}

}