<?php

use App\Components\CoreMySQLMigration;

class m170704_135565_create_support_message_attachment extends CoreMySQLMigration
{
    public $table = '{{%support_message_attachment}}';

    public $indexes = [ 'messageId', 'type' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'messageId' => $this->integer()->notNull(),
            'type' => "ENUM('file', 'image') NOT NULL",
            'filename' => $this->string(200)->notNull(),
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }

}
