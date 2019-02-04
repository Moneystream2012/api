<?php

use yii\db\Migration;

class m171030_183937_add_old_password_to_minex_user extends Migration
{
    public $table = '{{%user_auth_access}}';

    public function safeUp()
    {
        $this->addColumn($this->table, 'old_password', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'old_password');
    }
}
