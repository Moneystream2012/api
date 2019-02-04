<?php

use yii\db\Migration;

class m171026_134442_minex_finance_transaction_create_foreign_key extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_transaction}}';

    public $foreignKeys = [
        [
            'name' => 'fk_transaction_1',
            'table' => '{{%finance_transaction}}',
            'columns' => 'parkingId',
            'refTable' => '{{%finance_parking}}',
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
