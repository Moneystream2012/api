<?php

use App\Components\CoreMySQLMigration;

class m170704_135568_create_parking_log extends CoreMySQLMigration
{
    public $table = '{{%parking_log}}';

    public $indexes = [ 'parkingId', 'status', 'createdAt' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'parkingId' => $this->integer()->notNull(),
            'status' => "ENUM('pending', 'active', 'canceled', 'completed') NOT NULL",
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }
}
