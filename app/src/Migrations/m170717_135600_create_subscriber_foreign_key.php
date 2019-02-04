<?php

use App\Components\CoreMySQLMigration;

class m170717_135600_create_subscriber_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%subscriber}}';

    public $foreignKeys = [
        [
            'name' => 'fk_subscriber_1',
            'table' => '{{%subscriber}}',
            'columns' => 'sourceId',
            'refTable' => '{{%subscribe_source}}',
            'refColumns' => 'id',
            'delete' => self::RESTRICT,
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
