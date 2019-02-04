<?php

use yii\db\Migration;

class m171017_105206_drop_microtime_column extends Migration
{
    public $table = '{{%finance_address_balance}}';

    public function safeUp()
    {
        $this->dropColumn($this->table, 'lastSyncMicrotime');
    }

    public function safeDown()
    {
        $this->addColumn($this->table, 'lastSyncMicrotime', $this->double());
    }
}
