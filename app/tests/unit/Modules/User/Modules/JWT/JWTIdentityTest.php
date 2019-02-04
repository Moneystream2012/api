<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 19.10.17
 * Time: 18:07
 */
declare(strict_types=1);

namespace tests\unit\Modules\User\Modules\JWT;

use App\Modules\Database\User;
use App\Modules\User\Modules\JWT\JWTIdentity;
use AspectMock\Test;
use Codeception\Specify;
use tests\fixtures\User\UserFixture;
use tests\unit\BaseTestCase;
use yii\web\UnauthorizedHttpException;


/**
 * Class JWTBehaviorTest
 * @package tests\unit\Modules\User\Modules\JWT
 */
class JWTIdentityTest extends BaseTestCase
{

	use Specify;
	/**
	 * @var JWTIdentity
	 */
	public $testedClass = JWTIdentity::class;

	/**
	 *
	 */
	public function _before() {
		$reflection = new \ReflectionClass($this->testedClass);
		$this->testedClass = $reflection->newInstanceWithoutConstructor();
			//new $this->testedClass(1, 'foo');
		parent::_before();
	}


	/**
	 *
	 */
	public function testFindIdentityByAccessToken() {
		$cryptor = new class {
				public function decode($var) {
					return $var;
				}
		};
		$res = Test::double(JWTIdentity::class, [
			'validateAuth' => true,
			'updateToken'  => true,
			'getCryptor'   => $cryptor
		]);
		$identity = JWTIdentity::findIdentityByAccessToken(['userId' => 1, 'id' => 1, 'address' => 'address']);
		$this->assertInstanceOf(JWTIdentity::class, $identity);
		$res->verifyInvoked('validateAuth');
		$res->verifyInvoked('updateToken');
		$res->verifyInvoked('getCryptor');



		$res = Test::double(JWTIdentity::class, [
			'getCryptor'   => $cryptor
		]);
		$identity = JWTIdentity::findIdentityByAccessToken([]);
		$this->assertFalse($identity);
		$res->verifyInvoked('getCryptor');


		$res = Test::double(JWTIdentity::class, [
			'validateAuth' => false,
			'getCryptor'   => $cryptor
		]);
		$identity = JWTIdentity::findIdentityByAccessToken([]);
		$this->assertFalse($identity);
		$res->verifyInvoked('getCryptor');
		$res->verifyInvoked('validateAuth');

		$res = Test::double(JWTIdentity::class, [
			'validateAuth' => true,
			'getCryptor'   => $cryptor
		]);
		$identity = JWTIdentity::findIdentityByAccessToken([]);
		$this->assertFalse($identity);
		$res->verifyInvoked('getCryptor');
		$res->verifyInvoked('validateAuth');
		Test::clean();
	}


	/**
	 *
	 */
	public function testValidateAuthPositive(): void {
		$this->expectException(UnauthorizedHttpException::class);
		$res = $this->invokeMethod($this->testedClass, 'validateAuth', [
			[],
			11
		]);
		$this->assertTrue($res);
	}

	/**
	 * @dataProvider validateAuthNegativeDataProvider
	 */
	public function testValidateAuthNegative(array $data): void {
		$res = $this->invokeMethod($this->testedClass, 'validateAuth', [
			$data,
			11
		]);
		$this->assertFalse($res);

	}
	public function validateAuthNegativeDataProvider(): array {
		return [
			[[
				'id'          => '1',
				'userId'      => '1',
				'address'     => '1',
				'ip'          => '1',
				'userAgent'   => '1',
				'sessionTime' => '1',
				'dateCreated' => '1',
				'dateClosed'  => '1',
			]],
			[[
				'id'          => '1',
				'userId'      => '1',
				'address'     => '1',
				'ip'          => null,
				'userAgent'   => '1',
				'sessionTime' => '1',
				'dateCreated' => '1',
				'dateClosed'  => '1',
			]],
			[[
				'id'          => '1',
				'userId'      => '1',
				'address'     => '1',
				'ip'          => null,
				'userAgent'   => null,
				'sessionTime' => '1',
				'dateCreated' => '1',
				'dateClosed'  => '1',
			]],

		];
	}

	/**
	 *
	 */
	public function testUpdateToken() {
		$this->invokeMethod($this->testedClass, 'updateToken', [['userId' => 1]]);
		$res = \Yii::$app->getResponse()->getHeaders()->toArray();
		$this->assertArrayHasKey('access-token', $res);
		$this->assertArrayHasKey('userid', $res);
		$this->assertArrayHasKey('token-type', $res);
		$this->assertEquals('Bearer JWT', $res['token-type'][0]);

	}

	public function testDestroySession() {
		return;
		$testedClass = $this->testedClass;

		$this->specify('Positive', function () use ($testedClass) {
			Test::double(\yii\redis\Connection::class, ['exists' => true, 'del' => true]);
			$this->assertTrue($testedClass->destroySession());
			Test::clean();
		});

		$this->specify('Negative', function () use ($testedClass) {
			Test::double(\yii\redis\Connection::class, ['exists' => false]);
			$this->assertFalse($testedClass->destroySession());
			Test::clean();
		});



	}

}