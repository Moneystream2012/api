<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 17.08.17
 * Time: 11:05
 */
declare(strict_types=1);

namespace tests\fixtures\Support;

use App\Modules\Database\SupportAvatar;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SupportAvatarFixture
 * @package tests\fixtures\Support
 */
class SupportAvatarFixture extends ActiveFixture
{
	use FixtureSupport;

	public $modelClass = SupportAvatar::class;

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
			'userId'   => '',
			'filename' => ''
		];
	}

	public function itemRootUser() {
		return [
			'id'       => 1,
			'userId'   => '1',
			'filename' => 'foo.jpg'
		];
	}
}