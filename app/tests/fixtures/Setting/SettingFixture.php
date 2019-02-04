<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 17:08
 */
declare(strict_types=1);

namespace tests\fixtures\Setting;

use App\Modules\Database\Setting;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SubscribeSourceFixture
 * @package tests\fixtures\Subscribe
 */
class SettingFixture extends ActiveFixture
{

	use FixtureSupport;

	public $modelClass = Setting::class;

	public $depends = [SettingGroupFixture::class];

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
			'id'        => '',
			'groupId'   => '',
			'name'      => '',
			'shortName' => '',
			'value'     => '',
			'default'   => '',
			'createdAt' => '2000-01-01 00:00:00',
		];
	}

	public function itemRootUser():array  {
		return [
			'id'        => '1',
			'groupId'   => '1',
			'name'      => 'foo',
			'shortName' => 'bar',
			'value'     => 'true',
			'default'   => 'null',
			//'createdAt' => '2000-01-01 00:00:00'
		];
	}

}