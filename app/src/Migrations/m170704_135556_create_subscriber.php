<?php

use App\Components\CoreMySQLMigration;

class m170704_135556_create_subscriber extends CoreMySQLMigration
{
    public $table = '{{%subscriber}}';

    public $indexes = [ 'userId', 'sourceId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'sourceId' => $this->integer(2)->notNull(),
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }

}
