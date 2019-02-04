<?php

use yii\db\Migration;

class m171026_130046_minex_finance_parking_log_add_foreign_keys extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_parking_log}}';

    public $foreignKeys = [
        [
            'name' => 'fk_parking_log_1',
            'table' => '{{%finance_parking_log}}',
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
