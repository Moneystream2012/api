<?php

use yii\db\Migration;

class m171004_142304_add_admin_user extends Migration
{
	public function safeUp() {
		$this->insert('{{%user}}', [
			'id'           => 1,
			'username'     => 'testUser',
			'active'       => 1,
			'notification' => 1,
			'lastSync'     => '2017-09-21 15:34:07',
			'createdAt'    => '2017-09-21 15:34:07',
			'updatedAt'    => '2017-09-21 15:34:07',
			'moderatorId'  => 1,
			'role'         => 'admin',
		]);


		$this->insert('{{%user_auth_access}}', [
			'userId'       => 1,
			'address'      => 'XVBcuktbPLr7QqFwBzEySjKFv5ZLwuBHhx',
			'password'     => Yii::$app->security->generatePasswordHash('kjashdakjsd832y0e9du3478'),
			'tfauthCode'   => 1,
			'tfauthActive' => 2,
			'lastEnter'    => '2017-09-21 15:34:08'
		]);

		$this->insert('{{%finance_address_balance}}', [
			'address'  => 'XVBcuktbPLr7QqFwBzEySjKFv5ZLwuBHhx',
			'balance'  => 0,
			'lastSync' => '2017-09-21 15:34:08',
		]);

	}

	public function safeDown() {

	}
}
