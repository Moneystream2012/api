<?php

use yii\db\Migration;

class m171026_135232_minex_finance_transaction_log_create_foreign_keys extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_transaction_log}}';

    public $foreignKeys = [
    [
        'name' => 'fk_transaction_log_1',
        'table' => '{{%finance_transaction_log}}',
        'columns' => 'transactionId',
        'refTable' => '{{%finance_transaction}}',
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
