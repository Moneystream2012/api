<?php

use yii\db\Migration;

class m171013_145417_add_microtime_column_to_address_balance extends Migration
{

    public $table = '{{%finance_address_balance}}';

    public function safeUp()
    {
        $this->addColumn($this->table, 'lastSyncMicrotime', $this->double());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'lastSyncMicrotime');
    }
}
