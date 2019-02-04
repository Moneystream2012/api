<?php


use App\Components\CoreMySQLMigration;

class m170904_135933_finance_alter_address_balance_add_index_addr extends CoreMySQLMigration
{
    public $table = '{{%finance_address_balance}}';

    public $indexes = [ 'address', 'lastSync' ];


    public function safeUp()
    {
        $this->createTableIndexes();
    }

    public function safeDown()
    {
        $this->dropTableIndexes();
    }
}
