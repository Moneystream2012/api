<?php

use App\Components\CoreMySQLMigration;

class m170704_135566_create_parking extends CoreMySQLMigration
{
    public $table = '{{%parking}}';

    public $indexes = [
        'userId',
        'typeId',
        'status',
        ['name'=>'complex_typeId_status','columns'=>'typeId,status']
    ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'typeId' => $this->integer(2)->notNull(),
            'amount' => $this->bigInteger()->notNull(),
            'rate' => $this->float()->notNull(),
            'createdAt' => $this->datetime()->notNull(),
            'status' => "ENUM('pending', 'active', 'canceled', 'completed') NOT NULL DEFAULT 'active'",
        ]);
    }

}
