<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 01.08.17
 * Time: 11:39
 */

namespace tests\fixtures\User;

use App\Modules\User\Models\User;
use tests\_support\fixtures\FixtureSupport;
use Yii;
use yii\test\ActiveFixture;

/**
 * Class UserFixture
 * @package fixtures\User
 */
class UserFixture extends ActiveFixture
{
    use FixtureSupport;

    public $modelClass = User::class;

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
            'username'     => '',
            'active'       => 1,
            'notification' => 0,
            'email'        => '',
            'phone'        => '',
            'countryCode'  => '',
            'lastSync'     => Yii::$app->formatter->asDatetime(time()),
            'createdAt'    => Yii::$app->formatter->asDatetime(time()),
            'updatedAt'    => Yii::$app->formatter->asDatetime(time()),
            'moderatorId'  => 1,
        ];
    }

    public function itemRootUser() {
        return [
            'id'           => 1,
            'username'     => 'fooBarBaz',
            'active'       => 1,
            'notification' => 0,
            'email'        => 'fooBarBaz@localhost.local',
            'phone'        => '+3000000000',
            'countryCode'  => ''
        ];
    }

	public function itemUser() {
		return [
			'id'           => 2,
			'username'     => 'user',
			'active'       => 1,
			'notification' => 0,
			'email'        => 'user@localhost.local',
			'phone'        => '+3000000002',
			'countryCode'  => '',
			'role' => 'user'
		];
	}

	public function itemSupportUser() {
		return [
			'id'           => 3,
			'username'     => 'support',
			'active'       => 1,
			'notification' => 0,
			'email'        => 'support@localhost.local',
			'phone'        => '+3000000003',
			'countryCode'  => '',
			'role' => 'support'
		];
	}

	public function itemAdminUser() {
		return [
			'id'           => 4,
			'username'     => 'admin',
			'active'       => 1,
			'notification' => 0,
			'email'        => 'admin@localhost.local',
			'phone'        => '+3000000004',
			'countryCode'  => '',
			'role' => 'admin'
		];
	}
}
