<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.10.17
 * Time: 15:40
 */
declare(strict_types=1);

namespace tests\unit\Modules\User\Modules\JWT;

use App\Modules\User\Modules\JWT\JWTCrypror;
use Codeception\Specify;
use function Go\ParserReflection\Stub\funcWithoutStaticVars;
use tests\unit\BaseTestCase;
use yii\base\InvalidConfigException;

/**
 * Class JWTCryprorTest
 * @package tests\unit\Modules\User\Modules\JWT
 */
class JWTCryprorTest extends BaseTestCase
{

	use Specify;
	/**
	 * @var JWTCrypror
	 */
	public $testedClass = JWTCrypror::class;


	public function testInit() {
		$this->specify('JWT privateKey not set test', function () {
			try {
				\Yii::createObject($this->testedClass);
				$this->fail('Expected exception InvalidConfigException not thrown');
			} catch (InvalidConfigException $e) {
				$this->throwException($e);
			}
		});


		$this->specify('JWT publicKey not set test', function () {
			try {
				\Yii::createObject([
					'class' => JWTCrypror::class,
					'privateKey' => 'foo',
				]);
				$this->fail('Expected exception InvalidConfigException not thrown');
			} catch (InvalidConfigException $e) {
				$this->throwException($e);
			}
		});

		$this->specify('not supported Algorithm', function () {
			try {
				\Yii::createObject([
					'class' => JWTCrypror::class,
					'privateKey' => 'foo',
					'publicKey'  => 'foo',
					'algorithm'  => 'undefined'
				]);


				$this->fail('Expected exception InvalidConfigException not thrown');
			} catch (InvalidConfigException $e) {
				$this->throwException($e);
			}
		});
	}


	public function testEncode() {
		$this->createObject();
		//Test::double(\Firebase\JWT\JWT::class, ['encode' => 'yes']);
		$result = $this->testedClass->encode(['foo']);
		$this->assertStringEqualsFile(__DIR__ . '/data/example_encode', $result);
	}

	public function testDecode() {
		$this->createObject();
		$string = file_get_contents(__DIR__ . '/data/example_encode');
		$return = $this->testedClass->decode($string);
		$this->assertTrue(is_array($return));
	}

	private function createObject() {
		$this->testedClass = \Yii::createObject([
			'class'      => $this->testedClass,
			'publicKey'  => __DIR__ . '/data/pubkey.pem',
			'privateKey' => __DIR__ . '/data/privkey.pem'
		]);
	}
}