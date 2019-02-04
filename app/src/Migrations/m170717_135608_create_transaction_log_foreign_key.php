<?php

use App\Components\CoreMySQLMigration;

class m170717_135608_create_transaction_log_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%transaction_log}}';

    public $foreignKeys = [
        [
            'name' => 'fk_transaction_log_1',
            'table' => '{{%transaction_log}}',
            'columns' => 'transactionId',
            'refTable' => '{{%transaction}}',
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
