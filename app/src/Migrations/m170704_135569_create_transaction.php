<?php

use App\Components\CoreMySQLMigration;

class m170704_135569_create_transaction extends CoreMySQLMigration
{
    public $table = '{{%transaction}}';

    public $indexes = [ 'hash', 'parkingId', 'status' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'hash' => $this->string(64)->notNull(),
            'parkingId' => $this->integer()->notNull(),
            'amount' => $this->bigInteger()->notNull(),
            'fee' => $this->bigInteger()->notNull(),
            'status' => "ENUM('pending', 'completed', 'canceled') NOT NULL DEFAULT 'pending'",
            'createdAt' => $this->datetime()->notNull(),
            'updatedAt' => $this->datetime()->notNull(),
        ]);
    }

}
