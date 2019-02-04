<?php

use yii\db\Migration;

class m171026_135221_minex_finance_transaction_log_delete_foreign_keys extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_transaction_log}}';

    public $foreignKeys = [
        [
            'name' => 'fk_transaction_log_1',
            'table' => '{{%finance_transaction_log}}',
            'columns' => 'transactionId',
            'refTable' => '{{%finance_transaction}}',
            'refColumns' => 'id',
            'delete' => self::RESTRICT,
            'update' => self::CASCADE,
        ]
    ];


    public function safeUp()
    {
        $this->dropForeignKeys();

    }

    public function safeDown()
    {
        $this->createForeignKeys();
    }
}
