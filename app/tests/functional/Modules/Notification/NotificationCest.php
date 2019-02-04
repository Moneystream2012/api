<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 12:02
 */
declare(strict_types=1);

namespace tests\functional\Modules\Notification;

use \Codeception\Util\HttpCode;
use tests\_support\RestMultyCest;
use tests\fixtures\{
	User\UserFixture,
	User\UserAuthAccessFixture,
	User\UserAuthAssignmentFixture,
	Notification\NotificationFixture
};

/**
 * Class SubscribeMessageCest
 * @package tests\functional\Modules\Notification
 */
class NotificationCest
{
	use RestMultyCest;

	public $url = 'notification';

	//
	public function _fixtures(): array
    {
		return [
			UserFixture::class,
			UserAuthAccessFixture::class,
			UserAuthAssignmentFixture::class,
			NotificationFixture::class
		];
	}

	/**
	 * @example{"role":"admin", "title":"We will start new Bounty campaign soon!", "content":"Lets play again", "type":"info", "postedFor":{"0":1,"1":2,"2":3,"3":4,"4":5}, "seenBy":{"0":5}}
	 * @example{"role":"admin", "title":"We will start new Bounty campaign soon!", "content":"Lets play again", "type":"info", "postedFor":{}, "seenBy":{}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateSuccess($I, $example);
	}

	/**
	 * @example{"role":"admin", "title":"We will start new Bounty campaign soon!", "content":"Lets play again", "type":"info", "postedFor":{"0":1,"1":2,"2":3,"3":4,"4":5}, "seenBy":{"0":5}}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateFail($I, $example, HttpCode::FORBIDDEN);
	}

	/**
	 * @example{"role":"admin", "title":""}
	 * @example{"role":"admin", "content":""}

	 * @example{"role":"admin", "type":"informer"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function createEmptyFail(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testCreateFail($I, $example, HttpCode::UNPROCESSABLE_ENTITY);
	}

	/**
	 * @example{"role":"admin", "id":"1"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function deleteRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testDeleteFail($I, $example, HttpCode::NOT_FOUND);
	}

	/**
	 * @example{"role":"admin", "expected":[{"_id":"111a1e9bb8602400166a3ab2","title":"Income 20"}, {"_id":"222a1e9bb8602400166a3ab3","title":"Income 10"}]}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getListSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testGetListSuccess($I, $example);
	}

	/**
	 * @example{"role":"admin"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function getListRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testGetListFail($I, $example, HttpCode::FORBIDDEN);
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
	 * @example{"role":"admin", "id":"1"}
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
			//'_id'         => '__id',
			'title'       => 'We will start new Bounty campaign soon!',
			'content'     => 'Lets play again!',
			'type'        => 'info',
			'postedFor'   => [1,2,3,4,5],
			'seenBy'      => [5],
		];
	}

	//protected function putData() ** RESTRICTED


	/**
	 *  GET /user
	 */

	/**
	 * @example{"role":"^user", "url":"/user?seen=false", "expected":[{"_id":"222a1e9bb8602400166a3ab3","title":"Income 10","type":"info"}]}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function testGetUserNotifications(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testActionPositive($I, $example);

		$this->testActionPositive($I, [
			'role' => $example['role'],
			'url'  => $example['url'],
			'absent' => $example['expected'],
		]);
	}

	/**
	 * @example{"role":"^user", "allowed":"GET", "url":"/user"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function restrictedGetUserNotifications(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testRestrictedMethods($I, $example);
	}

	/**
	 * @example{"role":"^admin", "url":"/user"}
	 * @example{"role":"^support", "url":"/user"}
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function testGetUserNotificationsRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

		$this->testActionFail($I, $example);
	}

}