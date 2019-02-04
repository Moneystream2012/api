<?php

use App\Components\CoreMySQLMigration;

class m170704_135570_create_transaction_log extends CoreMySQLMigration
{
    public $table = '{{%transaction_log}}';

    public $indexes = [ 'transactionId', 'status', 'createdAt' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'transactionId' => $this->integer()->notNull(),
            'status' => "ENUM('pending', 'completed', 'canceled') NOT NULL",
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }
}
