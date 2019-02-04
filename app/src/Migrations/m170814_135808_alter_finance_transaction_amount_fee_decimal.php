<?php


use App\Components\CoreMySQLMigration;

class m170814_135808_alter_finance_transaction_amount_fee_decimal extends CoreMySQLMigration
{
    public $table = '{{%finance_transaction}}';


    public function safeUp()
    {
        $this->alterColumn( $this->table, 'amount', $this->decimal(16, 8)->notNull());
        $this->alterColumn( $this->table, 'fee', $this->decimal(16, 8)->notNull());
    }

    public function safeDown()
    {
        $this->alterColumn( $this->table, 'fee', $this->bigInteger()->notNull());
        $this->alterColumn( $this->table, 'amount', $this->bigInteger()->notNull());
    }
}
