<?php

use App\Components\CoreMySQLMigration;

class m170704_135564_create_support_message extends CoreMySQLMigration
{
    public $table = '{{%support_message}}';

    public $indexes = [ 'senderId', 'receiverId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'senderId' => $this->integer()->notNull(),
            'receiverId' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'createdAt' => $this->datetime()->notNull(),
            'seen' => $this->integer(1)->notNull()->defaultValue(0),
        ]);
    }

}
