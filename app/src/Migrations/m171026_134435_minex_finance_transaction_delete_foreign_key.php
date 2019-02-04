<?php

use yii\db\Migration;

class m171026_134435_minex_finance_transaction_delete_foreign_key extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_transaction}}';

    public $foreignKeys = [
        [
            'name' => 'fk_transaction_1',
            'table' => '{{%finance_transaction}}',
            'columns' => 'parkingId',
            'refTable' => '{{%finance_parking}}',
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
