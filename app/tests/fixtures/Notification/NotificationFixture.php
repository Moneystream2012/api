<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 17:08
 */
declare(strict_types=1);

namespace tests\fixtures\Notification;

use App\Modules\Notification\Models\Notification;
use tests\_support\fixtures\FixtureSupport;
use yii\mongodb\ActiveFixture;

/**
 * Class SubscribeSourceFixture
 * @package tests\fixtures\Subscribe
 */
class NotificationFixture extends ActiveFixture
{

	use FixtureSupport;

	public $modelClass = Notification::class;

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
			'_id'         => '',
			'title'       => '',
			'content'     => '',
			'type'        => '',
			'postedFor'   => '',
			'seenBy'      => '',
			'moderatorId' => '',
			'createdAt'   => '',
			'updatedAt'   => ''

		];
	}

	public function itemFirstNotification(): array {
		return [
			'_id'         => '111a1e9bb8602400166a3ab2',
			'title'       => 'Income 20',
			'content'     => 'You getting income 20 MNX on your balance',
			'type'        => 'info',
			'postedFor'   => [3,4,5],
			'seenBy'      => [3,4],
			'moderatorId' => 1,
			'createdAt'   => '2017-08-24 11:37:15',
			'updatedAt'   => '2017-08-24 11:37:15'
		];
	}

	public function itemSecondNotification(): array {
		return [
			'_id'         => '222a1e9bb8602400166a3ab3',
			'title'       => 'Income 10',
			'content'     => 'You getting income 10 MNX on your balance',
			'type'        => 'info',
			'postedFor'   => [2,3,4,5],
			'seenBy'      => [5],
			'moderatorId' => 1,
			'createdAt'   => '2017-08-24 11:37:15',
			'updatedAt'   => '2017-08-24 11:37:15'
		];
	}

	public function itemThirdNotification(): array {
		return [
			'_id'         => '333a1e9bb8602400166a3ab3',
			'title'       => 'Surprise',
			'content'     => 'Surprise Surprise Surprise',
			'type'        => 'info',
			'postedFor'   => [2,3],
			'seenBy'      => [2],
			'moderatorId' => 1,
			'createdAt'   => '2017-08-24 11:37:15',
			'updatedAt'   => '2017-08-24 11:37:15'
		];
	}
}