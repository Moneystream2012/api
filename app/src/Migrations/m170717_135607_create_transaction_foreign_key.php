<?php

use App\Components\CoreMySQLMigration;

class m170717_135607_create_transaction_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%transaction}}';

    public $foreignKeys = [
        [
            'name' => 'fk_transaction_1',
            'table' => '{{%transaction}}',
            'columns' => 'parkingId',
            'refTable' => '{{%parking}}',
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
