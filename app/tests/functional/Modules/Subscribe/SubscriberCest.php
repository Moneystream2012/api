<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 12:01
 */
declare(strict_types=1);

namespace tests\functional\Modules\Subscribe;

use \Codeception\Util\HttpCode;
use tests\_support\RestMultyCest;
use tests\fixtures\{
	User\UserFixture,
	User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
	Subscribe\SubscriberFixture
};

/**
 * Class SubscriberCest
 * @package tests\functional\Modules\Subscribe
 */
class SubscriberCest
{
	use RestMultyCest;

	public $url = 'subscriber';

	//
	public function _fixtures(): array
    {
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
			SubscriberFixture::class,
		];
	}

	/**
	 * @example{"role":"admin", "email":"test@minexsystems.com", "sourceId":1}
	 * @example{"role":"support", "email":"test@minexsystems.com", "sourceId":1}
	 * @example{"role":"user", "email":"test@minexsystems.com", "sourceId":1}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateSuccess($I, $example);
	}

	/**
	 * @example{"role":"admin", "email":""}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createEmptyFail(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
	}

	/**
	 * @example{"role":"admin", "expected":[{"id":1,"email":"test.admin@minexsystems.com"}, {"id":2,"email":"test.support@minexsystems.com"}, {"id":3,"email":"test.pupkin@minexsystems.com"}]}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testGetListSuccess($I, $example);
	}

	/**
	 * @example{"role":"admin", "id":"1", "email": "test.admin@minexsystems.com"}
	 * @example{"role":"user", "id":"1", "email": "test.pupkin@minexsystems.com"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function deleteSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

		list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);

		if (isset($role)) {
			$this->setUser($I, $role);

			$I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url .'/'. $data['id']), ['email' => $data['email']]);
			$I->canSeeResponseCodeIs(HttpCode::OK);
			$I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url .'/'. $data['id']), ['email' => $data['email']]);
			$I->canSeeResponseCodeIs(HttpCode::NOT_FOUND);
		}
	}

	/**
	 * @example{"role":"^support", "id":"1"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function deleteRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testDeleteFail($I, $example, HttpCode::FORBIDDEN);
	}

	/**
	 * @example{"role":"admin", "id":"1", "send":{}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function putRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testPutFail($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin", "id":"1", "expected":{}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getByIdRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testGetByIdFail($I, $example, HttpCode::NOT_FOUND);
	}


	/**
	 * @return array
	 */
	protected function createData(): array {
		return [
			"email"    => "test@minexsystems.com",
			"sourceId" => "1",
		];
	}

}