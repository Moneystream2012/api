<?php

use App\Components\CoreMySQLMigration;

class m170704_135553_create_user extends CoreMySQLMigration
{
    public $table = '{{%user}}';

    public $indexes = [ 'active', 'moderatorId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull(),
            'active' => $this->integer(1)->notNull(),
            'notification' => $this->integer(1)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'phone' => $this->string(30)->notNull()->unique(),
            'countryCode' => $this->string(3)->notNull(),
            'lastSync' => $this->datetime()->notNull(),
            'createdAt' => $this->datetime()->notNull(),
            'updatedAt' => $this->datetime()->notNull(),
            'moderatorId' => $this->integer()->notNull(),
        ]);
    }

}
