<?php


use App\Components\CoreMySQLMigration;

class m170814_135807_alter_finance_parking_amount_decimal extends CoreMySQLMigration
{
    public $table = '{{%finance_parking}}';


    public function safeUp()
    {
        $this->alterColumn( $this->table, 'amount', $this->decimal(16, 8)->notNull());
    }

    public function safeDown()
    {
        $this->alterColumn( $this->table, 'amount', $this->bigInteger()->notNull());
    }
}
