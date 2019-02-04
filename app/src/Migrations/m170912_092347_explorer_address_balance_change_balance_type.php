<?php

use yii\db\Migration;

class m170912_092347_explorer_address_balance_change_balance_type extends Migration
{

    public $table = '{{%finance_address_balance}}';

    public function safeUp()
    {
        $this->alterColumn($this->table, 'balance', $this->decimal(20, 8)->notNull());
    }

    public function safeDown()
    {
        $this->alterColumn($this->table, 'balance', $this->decimal(16, 8)->notNull());
    }
}
