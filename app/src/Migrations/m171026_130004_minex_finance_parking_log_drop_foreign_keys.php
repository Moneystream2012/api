<?php

use yii\db\Migration;

class m171026_130004_minex_finance_parking_log_drop_foreign_keys extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_parking_log}}';

    public $foreignKeys = [
        [
            'name' => 'fk_parking_log_1',
            'table' => '{{%finance_parking_log}}',
            'columns' => 'parkingId',
            'refTable' => '{{%parking}}',
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
