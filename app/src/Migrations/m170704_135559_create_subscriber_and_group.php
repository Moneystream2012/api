<?php

use App\Components\CoreMySQLMigration;

class m170704_135559_create_subscriber_and_group extends CoreMySQLMigration
{
    public $table = '{{%subscriber_and_group}}';

    public $indexes = [ 'subscriberId', 'groupId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'subscriberId' => $this->integer()->notNull(),
            'groupId' => $this->integer(2)->notNull(),
        ]);
    }

}
