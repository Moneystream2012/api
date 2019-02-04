<?php

use yii\db\Migration;

class m171030_184103_add_is_password_chaged_to_minex_user extends Migration
{
    public $table = '{{%user_auth_access}}';

    public function safeUp()
    {
        $this->addColumn($this->table, 'is_password_changed', $this->integer()->defaultValue(1));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'is_password_changed');
    }
}
