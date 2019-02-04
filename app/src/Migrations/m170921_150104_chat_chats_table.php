<?php

use yii\db\Migration;

class m170921_150104_chat_chats_table extends Migration
{
    public $table = '{{%chat}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'securedSessionId' => $this->string()->notNull(),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170921_150104_chat_chats_table cannot be reverted.\n";

        return false;
    }
    */
}
