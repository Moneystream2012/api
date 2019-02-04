<?php


use App\Components\CoreMySQLMigration;

class m170704_135558_create_subscriber_group extends CoreMySQLMigration
{
    public $table = '{{%subscriber_group}}';


    public function safeUp()
    {
        $this->createNewTable([
            'id' => $this->primaryKey(2),
            'name' => $this->string(100)->notNull(),
        ]);
    }

}
