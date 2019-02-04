<?php

use yii\db\Migration;

class m171018_163309_refactor_chat extends Migration
{
    public $table = '{{%chat}}';

    public function safeUp()
    {
        $this->alterColumn($this->table, 'securedSessionId', $this->string());
    }

    public function safeDown()
    {
        $this->alterColumn($this->table, 'securedSessionId', $this->string()->notNull());
    }
}
