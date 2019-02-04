<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 17.08.17
 * Time: 11:06
 */
declare(strict_types=1);

namespace tests\fixtures\Support;

use App\Modules\Database\SupportMessage;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SupportMessageFixture
 * @package tests\fixtures\Support
 */
class SupportMessageFixture extends ActiveFixture
{
	use FixtureSupport;

	public $modelClass = SupportMessage::class;

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
			//'id'           => '',
			'senderId'   => '',
			'receiverId' => '',
			'content'    => '',
			'createdAt'  => '',
			'seen'       => ''
		];
	}

	public function itemRootUser() {
		return [
			'id'           => '1',
			'senderId'   => '1',
			'receiverId' => '1',
			'content'    => 'foo',
			'createdAt'  => '2017-08-18 07:28:02',
			'seen'       => 0
		];
	}
}