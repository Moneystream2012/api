<?php

use App\Components\CoreMySQLMigration;

class m170904_135934_finance_create_address_balance_log extends CoreMySQLMigration
{
    public $table = '{{%finance_address_balance_log}}';

    public $indexes = [ 'addressBalanceId', 'transactionId', 'status', 'createdAt' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'addressBalanceId' => $this->integer()->notNull(),
            'transactionId' => $this->string(64)->notNull(),
            'amount' => $this->decimal(16, 8)->notNull(),
            'balance' => $this->decimal(16, 8)->notNull(),
            'status' => "ENUM('direct', 'rollback') NOT NULL",
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }
}
