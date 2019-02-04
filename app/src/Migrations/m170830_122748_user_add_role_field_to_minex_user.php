<?php

use yii\db\Migration;

class m170830_122748_user_add_role_field_to_minex_user extends Migration
{
	public $table = '{{%user}}';

	public const USER_ROLE = 'user';
	public const ADMIN_ROLE = 'admin';
	public const SUPPORT_ROLE = 'support';

	public function safeUp() {
		$this->addColumn($this->table, 'role', "ENUM('" . self::USER_ROLE . "', '" . self::SUPPORT_ROLE . "', '" . self::ADMIN_ROLE . "') NOT NULL DEFAULT '" . self::USER_ROLE . "'");
	}

	public function safeDown() {
		$this->dropColumn($this->table, 'role');
	}

}
