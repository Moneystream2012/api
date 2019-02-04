<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 17:08
 */
declare(strict_types=1);

namespace tests\fixtures\Subscribe;

use App\Modules\Database\SubscriberAndGroup;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SubscribeSourceFixture
 * @package tests\fixtures\Subscribe
 */
class SubscriberAndGroupFixture extends ActiveFixture
{

	use FixtureSupport;

	public $modelClass = SubscriberAndGroup::class;

	public $depends = [
		SubscriberGroupFixture::class,
		SubscriberFixture::class
	];

	/**
	 * @return array
	 */
	public function getData():array {
		return $this->getFixturesData();
	}

	/**
	 * @return array
	 */
	public static function getDefaultValuesByFields():array  {
		return [
			//'id'       => '',
			'subscriberId'   => '',
			'groupId'   => ''
		];
	}

	public function itemRootUser():array  {
		return [
			//'id'       => '',
			'subscriberId'   => '1',
			'groupId'   => '1'
		];
	}

}