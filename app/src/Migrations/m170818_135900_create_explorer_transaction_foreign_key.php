<?php

use App\Components\CoreMySQLMigration;

class m170818_135900_create_explorer_transaction_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%explorer_transaction}}';

    public $foreignKeys = [
        [
            'name' => 'fk_explorer_transaction_1',
            'table' => '{{%explorer_transaction}}',
            'columns' => 'block',
            'refTable' => '{{%explorer_block}}',
            'refColumns' => 'hash',
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
