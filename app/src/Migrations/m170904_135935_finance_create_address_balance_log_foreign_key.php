<?php

use App\Components\CoreMySQLMigration;

class m170904_135935_finance_create_address_balance_log_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%finance_address_balance_log}}';

    public $foreignKeys = [
        [
            'name' => 'fk_finance_address_balance_log_1',
            'table' => '{{%finance_address_balance_log}}',
            'columns' => 'addressBalanceId',
            'refTable' => '{{%finance_address_balance}}',
            'refColumns' => 'id',
            'delete' => self::CASCADE,
            'update' => self::CASCADE,
        ],
        [
            'name' => 'fk_finance_address_balance_log_2',
            'table' => '{{%finance_address_balance_log}}',
            'columns' => 'transactionId',
            'refTable' => '{{%explorer_transaction}}',
            'refColumns' => 'hash',
            'delete' => self::CASCADE,
            'update' => self::CASCADE,
        ],
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
