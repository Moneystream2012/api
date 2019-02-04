<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 17:08
 */
declare(strict_types=1);

namespace tests\fixtures\Subscribe;

use App\Modules\Database\SubscriberGroup;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SubscribeSourceFixture
 * @package tests\fixtures\Subscribe
 */
class SubscriberGroupFixture extends ActiveFixture
{

	use FixtureSupport;

	public $modelClass = SubscriberGroup::class;

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->getFixturesData();
	}

	/**
	 * @return array
	 */
	public static function getDefaultValuesByFields(): array {
		return [
			//'id'   => '',
			'name' => '',
		];
	}

	public function itemRootUser() {
		return [
			'id'   => '1',
			'name' => 'FooBarBaz'
		];
	}

}