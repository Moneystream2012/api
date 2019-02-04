<?php


use App\Components\CoreMySQLMigration;

class m170814_135806_alter_finance_user_balance_decimal extends CoreMySQLMigration
{
    public $table = '{{%finance_user_balance}}';


    public function safeUp()
    {
        $this->alterColumn( $this->table, 'balance', $this->decimal(16, 8)->notNull());
    }

    public function safeDown()
    {
        $this->alterColumn( $this->table, 'balance', $this->bigInteger()->notNull()->unsigned());
    }
}
