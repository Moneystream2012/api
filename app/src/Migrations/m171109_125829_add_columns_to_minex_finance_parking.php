<?php

use yii\db\Migration;

class m171109_125829_add_columns_to_minex_finance_parking extends Migration
{

    public $table = '{{%finance_parking}}';

    public function safeUp()
    {
        $this->addColumn($this->table, 'endDate', $this->dateTime());
        $this->addColumn($this->table, 'returnedAmount', $this->decimal(16,8));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'endDate');
        $this->dropColumn($this->table, 'returnedAmount');
    }
}
