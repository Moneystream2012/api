<?php

use App\Components\CoreMySQLMigration;

class m170717_135606_create_parking_log_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%parking_log}}';

    public $foreignKeys = [
        [
            'name' => 'fk_parking_log_1',
            'table' => '{{%parking_log}}',
            'columns' => 'parkingId',
            'refTable' => '{{%parking}}',
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
