<?php

use App\Components\CoreMySQLMigration;

class m170717_135604_create_support_message_attachment_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%support_message_attachment}}';

    public $foreignKeys = [
        [
            'name' => 'fk_support_message_attachment_1',
            'table' => '{{%support_message_attachment}}',
            'columns' => 'messageId',
            'refTable' => '{{%support_message}}',
            'refColumns' => 'id',
            'delete' => self::CASCADE,
            'update' => self::CASCADE,
        ]
    ];


    public function safeUp()
    {
        $this->createForeignKeys();
    }

    public function safeDown()
    {
        $this->dropForeignKeys();
    }
}
