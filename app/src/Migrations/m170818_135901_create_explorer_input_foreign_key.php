<?php

use App\Components\CoreMySQLMigration;

class m170818_135901_create_explorer_input_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%explorer_input}}';

    public $foreignKeys = [
        [
            'name' => 'fk_explorer_input_1',
            'table' => '{{%explorer_input}}',
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
