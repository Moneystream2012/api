<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 12:45
 */
declare(strict_types=1);

namespace tests\functional\Modules\Support;

use tests\fixtures\Support\SupportAvatarFixture;

/**
 * Class AvatarCest
 * @package tests\functional\Modules\Support
 */
class AvatarCestUnstable
{


	/**
	 * @return array
	 */
	public function _fixtures(): array {
		return [
			SupportAvatarFixture::class
		];
	}

	/**
	 *
	 */
	private const URL = 'support/avatar';


	/**
	 * @param \FunctionalTester $I
	 */
	public function create(\FunctionalTester $I): void {
		$I->sendPOST(\Yii::$app->getUrlManager()->createUrl(self::URL), [
			'userId'   => 1,
			'filename' => 'foo'
		]);
		$I->canSeeResponseIsJson();
		$I->canSeeResponseCodeIs(201);
		$I->canSeeResponseContainsJson([
			//'id' => '',
			'userId'   => '1',
			'filename' => 'foo'
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function delete(\FunctionalTester $I): void {
		$I->sendDELETE(\Yii::$app->getUrlManager()->createUrl(self::URL . '/1'));
		$I->canSeeResponseCodeIs(204);

		$I->sendDELETE(\Yii::$app->getUrlManager()->createUrl(self::URL . '/1'));
		$I->canSeeResponseCodeIs(404);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function getList(\FunctionalTester $I): void {
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl(self::URL));
		$I->canSeeResponseCodeIs(200);
		$I->canSeeResponseContainsJson([
			[
				'id'       => 1,
				'userId'   => 1,
				'filename' => 'foo.jpg'

			]
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function getById(\FunctionalTester $I): void {
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl(self::URL . '/1'));
		$I->canSeeResponseCodeIs(200);
		$I->canSeeResponseContainsJson([
			'id'       => 1,
			'userId'   => 1,
			'filename' => 'foo.jpg'
		]);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function userAvatar(\FunctionalTester $I): void {
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl(self::URL . '/user-avatar/'), ['id' => 1]);
		$I->canSeeResponseCodeIs(200);
		$I->canSeeResponseContainsJson([
			'id'       => 1,
			'filename' => 'foo.jpg'
		]);
	}


}