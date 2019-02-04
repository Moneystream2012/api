<?php

use yii\db\Migration;

class m171030_161446_finance_transaction_add_status extends \App\Components\CoreMySQLMigration
{
    public $table='{{%finance_transaction}}';

    public function safeUp()
    {
        $this->alterColumn($this->table, 'status', "ENUM('pending', 'completed', 'canceled', 'blank') NOT NULL DEFAULT 'pending'");
    }

    public function safeDown()
    {
        $this->alterColumn($this->table, 'status', "ENUM('pending', 'completed', 'canceled') NOT NULL DEFAULT 'pending'");
    }

}
