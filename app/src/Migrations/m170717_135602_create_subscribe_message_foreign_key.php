<?php

use App\Components\CoreMySQLMigration;

class m170717_135602_create_subscribe_message_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%subscribe_message}}';

    public $foreignKeys = [
        [
            'name' => 'fk_subscribe_message_1',
            'table' => '{{%subscribe_message}}',
            'columns' => 'groupId',
            'refTable' => '{{%subscriber_group}}',
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
