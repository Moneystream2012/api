<?php

use yii\db\Migration;

class m171018_161557_add_status_to_chat_table extends Migration
{
    public $table = '{{%chat}}';

    public function safeUp()
    {
        $this->addColumn($this->table, 'status', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'status');
    }
}
