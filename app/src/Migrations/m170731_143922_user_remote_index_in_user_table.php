<?php

use yii\db\Migration;

class m170731_143922_user_remote_index_in_user_table extends Migration
{
    public $table = '{{%user}}';

    public function safeUp()
    {
        $this->dropIndex('email', $this->table);
        $this->dropIndex('phone', $this->table);
    }

    public function safeDown()
    {
        $this->createIndex('email', $this->table, 'email', true);
        $this->createIndex('phone', $this->table, 'phone', true);
    }

}
