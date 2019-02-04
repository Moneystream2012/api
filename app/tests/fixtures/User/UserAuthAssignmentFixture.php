<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 02.08.17
 * Time: 16:30
 */

namespace tests\fixtures\User;

use App\Modules\Database\AuthAssignment;

use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class UserAuthAssignmentFixture
 * @package tests\fixtures\User
 */
class UserAuthAssignmentFixture extends ActiveFixture
{
    use FixtureSupport;

    public $modelClass = AuthAssignment::class;

	public $depends = [UserFixture::class];

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
	        'item_name'     => '',
            'user_id'       => 0,
            'created_at'    => '2000-01-01 00:00:00'
        ];
    }

    public function itemRootUser() {
        return [
            'item_name'     => 'admin',
            'user_id'       => 1,
        ];
    }

	public function itemUser() {
		return [
			'item_name'     => 'user',
			'user_id'       => 2,
		];
	}

	public function itemSupportUser() {
		return [
			'item_name'     => 'support',
			'user_id'       => 3,
		];
	}

	public function itemAdminUser() {
		return [
			'item_name'     => 'admin',
			'user_id'       => 4,
		];
	}
}
