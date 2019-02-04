<?php

use App\Components\CoreMySQLMigration;

class m170717_135603_create_setting_foreign_key extends CoreMySQLMigration
{
    public $table = '{{%setting}}';

    public $foreignKeys = [
        [
            'name' => 'fk_settings_1',
            'table' => '{{%setting}}',
            'columns' => 'groupId',
            'refTable' => '{{%setting_group}}',
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
