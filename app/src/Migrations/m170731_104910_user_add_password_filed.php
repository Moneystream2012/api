<?php

use yii\db\Migration;

class m170731_104910_user_add_password_filed extends Migration
{
    public $table = '{{%user_auth_access}}';


    public function safeUp()
    {
        $this->addColumn($this->table, 'password', $this->string()->notNull()->after('address'));
        $this->dropColumn($this->table,'sign');
    }

    public function safeDown()
    {
        $this->addColumn($this->table, 'sign', $this->string(55)->after('address'));
        $this->dropColumn($this->table, 'password');
    }
}
