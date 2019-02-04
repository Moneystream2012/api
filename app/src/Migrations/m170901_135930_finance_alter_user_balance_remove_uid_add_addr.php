<?php


use App\Components\CoreMySQLMigration;

class m170901_135930_finance_alter_user_balance_remove_uid_add_addr extends CoreMySQLMigration
{
    public $table = '{{%finance_user_balance}}';


    public function safeUp()
    {
        $this->dropColumn( $this->table, 'userId');
        $this->addColumn( $this->table, 'address', $this->string(35)->notNull()->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn( $this->table, 'address');
        $this->addColumn( $this->table, 'userId', $this->integer()->notNull()->unsigned());
    }
}
