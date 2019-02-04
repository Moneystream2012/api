<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 12:45
 */
declare(strict_types=1);

namespace tests\functional\Modules\Support;

use tests\_support\RestCest;
use tests\fixtures\Support\SupportMessageFixture;

/**
 * Class AvatarCest
 * @package tests\functional\Modules\Support
 */
class MessageCestUnstable
{
	use RestCest;

	/**
	 * @return array
	 */
	public function _fixtures(): array {
		return [
			SupportMessageFixture::class
		];
	}

	/**
	 * @var string
	 */
	public $url = 'support/message';

	/**
	 * @return array
	 */
	protected function create(): array {
		return [
			'data'     => [
				'senderId'   => 1,
				'receiverId' => 1,
				'content'    => 'foo',
				'createdAt'  => \Yii::$app->formatter->asDatetime(time()),
				'seen'       => 1,
			],
			'expected' => [
				'senderId'   => 1,
				'receiverId' => 1,
				'content'    => 'foo',
				'createdAt'  => \Yii::$app->formatter->asDatetime(time()),
				'seen'       => 1,
			]
		];
	}

	/**
	 * @return array
	 */
	protected function delete(): array {
		return [
			'data' => 1
		];
	}

	/**
	 * @return array
	 */
	protected function getList(): array {
		return [
			'expected' => [
				[
					'id'         => 1,
					'senderId'   => 1,
					'receiverId' => 1,
					'content'    => 'foo',
					'createdAt'  => '2017-08-18 07:28:02',
					'seen'       => '0'
				]
			]
		];
	}

	/**
	 * @return array
	 */
	protected function getById(): array {
		return [
			'data'     => '1',
			'expected' => [
				'id'         => 1,
				'senderId'   => 1,
				'receiverId' => 1,
				'content'    => 'foo',
				'createdAt'  => '2017-08-18 07:28:02',
				'seen'       => '0'
			]
		];
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function userMessage(\FunctionalTester $I): void {
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url . '/user-message/'), ['id' => 1]);
		$I->canSeeResponseCodeIs(200);
		$I->canSeeResponseContainsJson([
			'id'         => 1,
			'senderId'   => 1,
			'receiverId' => 1,
			'content'    => 'foo',
			'createdAt'  => '2017-08-18 07:28:02',
			'seen'       => '0'
		]);
	}


}