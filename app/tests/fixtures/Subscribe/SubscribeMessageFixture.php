<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 17:08
 */
declare(strict_types=1);

namespace tests\fixtures\Subscribe;

use App\Modules\Subscribe\Models\SubscribeMessage;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SubscribeSourceFixture
 * @package tests\fixtures\Subscribe
 */
class SubscribeMessageFixture extends ActiveFixture
{

	use FixtureSupport;

	public $modelClass = SubscribeMessage::class;

	public $depends = [SubscriberGroupFixture::class];

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->getFixturesData();
	}

	/**
	 * @return array
	 */
	public static function getDefaultValuesByFields ():array {
		return [
			//'id' => '',
			'title'     => 'foo',
			'content'   => 'bar',
			'authorId'  => '1',
			'groupId'   => '1',
			'createdAt' => '2017-08-18 14:34:05'

		];
	}

	public function itemFirstMessage():array  {
		return [
			//'id' => '',
			'title'     => 'first title',
			'content'   => 'first content',
			'authorId'  => '1',
			'groupId'   => '1',
		];
	}

	public function itemSecondMessage():array  {
		return [
			//'id' => '',
			'title'     => 'second title',
			'content'   => 'second content',
			'authorId'  => '1',
			'groupId'   => '1',
		];
	}

	public function itemThirdMessage():array  {
		return [
			//'id' => '',
			'title'     => 'third title',
			'content'   => 'third content',
			'authorId'  => '1',
			'groupId'   => '1',
		];
	}
}