<?php

use App\Components\CoreMySQLMigration;

class m170818_135902_create_explorer_output_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%explorer_output}}';

    public $foreignKeys = [
        [
            'name' => 'fk_explorer_output_1',
            'table' => '{{%explorer_output}}',
            'columns' => 'transactionId',
            'refTable' => '{{%explorer_transaction}}',
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
