<?php


use App\Components\CoreMySQLMigration;

class m170704_135557_create_subscribe_source extends CoreMySQLMigration
{
    public $table = '{{%subscribe_source}}';


    public function safeUp()
    {
        $this->createNewTable([
            'id' => $this->primaryKey(2),
            'name' => $this->string(100)->notNull(),
        ]);
    }

}
