<?php

use yii\db\Migration;

class m171005_174344_change_length_auth_code extends Migration
{
    public $table = '{{%user_auth_access}}';

    public function safeUp()
    {
        $this->alterColumn($this->table, 'tfauthCode', $this->string(20));
    }

    public function safeDown()
    {
        $this->alterColumn($this->table, 'tfauthCode', $this->string(10));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171005_174344_change_length_auth_code cannot be reverted.\n";

        return false;
    }
    */
}
