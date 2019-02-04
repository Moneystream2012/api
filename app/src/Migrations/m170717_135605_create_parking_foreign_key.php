<?php

use App\Components\CoreMySQLMigration;

class m170717_135605_create_parking_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%parking}}';

    public $foreignKeys = [
        [
            'name' => 'fk_parking_1',
            'table' => '{{%parking}}',
            'columns' => 'typeId',
            'refTable' => '{{%parking_type}}',
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
