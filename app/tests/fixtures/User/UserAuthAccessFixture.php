<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 02.08.17
 * Time: 16:30
 */

namespace tests\fixtures\User;

use App\Modules\Database\UserAuthAccess;

use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class UserAuthAccessFixture
 * @package tests\fixtures\User
 */
class UserAuthAccessFixture extends ActiveFixture
{
    use FixtureSupport;

    public $modelClass = UserAuthAccess::class;

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
            //'id'           => '',
            'userId'       => '',
            'address'      => '',
            'password'     => '',
            'tfauthCode'   => '',
            'tfauthActive' => 0,
            'lastEnter'    => '2000-01-01 00:00:00'
        ];
    }

    public function itemRootUser() {
        return [
            'id'           => 1,
            'userId'       => 1,
            'address'      => 'foobarfoobarfoobarfoobar',
            'password'     => '$2y$13$nzCrDR0aroiNuoJTgL1WEe.zHFr7OsMJQtzX/qBJzWNREeM/7lkWG',//foobarroot'
        ];
    }

	public function itemUser() {
		return [
			'id'           => 2,
			'userId'       => 2,
			'address'      => 'XWtUA1qBvisvnyxKWyBpiRgRwQNX3xiYGS',
			//sign "MinexBank"
			// HxkkEkrvavFdnHcIxk1BCOTKQsqFlFKLjNBY4mRNfL/PUFdM5D3KoeYGzh+kaYjM1a5MzYBmdx6XmbyP6vKtqEg=
			'password'     => '$2y$13$OZBrOa.C.y.5cezZ8ONQNuTzfjBO94CgqCcZfoImhCA9UTe.MTXrG'//foobaruser',
		];
	}

	public function itemSupportUser() {
		return [
			'id'           => 3,
			'userId'       => 3,
			'address'      => 'XVshdGYTzGi8cL6o6hmJ3Hn7w7oNgbqerS2',
			'password'     => '$2y$13$U0EShA6ZsPwnDbCVSlodRumvY9XVunnc9ir.jiZkZyuz9N0DLIfJC',//foobarsupport
		];
	}

	public function itemAdminUser() {
		return [
			'id'           => 4,
			'userId'       => 4,
			'address'      => 'XVshdGYTzGi8cL6o6hmJ3Hn7w7oNgbqerS3',
			'password'     => '$2y$13$PVSYIcI9lgs92v6pnDE71upPLPVz3Y6vHEkle11w4kuh48cqS8The', //foobaradmin,
		];
	}
}
