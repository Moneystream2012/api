<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 17:08
 */
declare(strict_types=1);

namespace tests\fixtures\Subscribe;

use App\Modules\Database\Subscriber;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SubscribeSourceFixture
 * @package tests\fixtures\Subscribe
 */
class SubscriberFixture extends ActiveFixture
{

	use FixtureSupport;

	public $modelClass = Subscriber::class;

	public $depends = [SubscribeSourceFixture::class];

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->getFixturesData();
	}

	/**
	 * @return array
	 */
	public static function getDefaultValuesByFields (): array {
		return [
			//'id'       => '',
			'email'   => '',
			'sourceId' => '',
			'createdAt' => '2000-01-01 00:00:00',
		];
	}

	public function itemAdminSubscriber() {
		return [
			//'id'       => '',
            'email' => 'test.admin@minexsystems.com',
			'sourceId' => '1',
		];
	}

	public function itemSupportSubscriber() {
		return [
			//'id'       => '',
			'email' => 'test.support@minexsystems.com',
			'sourceId' => '1',
		];
	}

	public function itemUserSubscriber() {
		return [
			//'id'       => '',
			'email' => 'test.pupkin@minexsystems.com',
			'sourceId' => '1',
		];
	}

}