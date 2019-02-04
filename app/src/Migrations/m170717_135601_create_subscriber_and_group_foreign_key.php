<?php

use App\Components\CoreMySQLMigration;

class m170717_135601_create_subscriber_and_group_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%subscriber_and_group}}';

    public $foreignKeys = [
        [
            'name' => 'fk_subscriber_and_group_1',
            'table' => '{{%subscriber_and_group}}',
            'columns' => 'subscriberId',
            'refTable' => '{{%subscriber}}',
            'refColumns' => 'id',
            'delete' => self::CASCADE,
            'update' => self::CASCADE,
        ],
        [
            'name' => 'fk_subscriber_and_group_2',
            'table' => '{{%subscriber_and_group}}',
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
