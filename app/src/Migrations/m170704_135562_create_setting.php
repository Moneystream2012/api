<?php


use App\Components\CoreMySQLMigration;

class m170704_135562_create_setting extends CoreMySQLMigration
{
    public $table = '{{%setting}}';

    public $indexes = [ 'groupId', 'shortName' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'groupId' => $this->integer(2)->notNull(),
            'name' => $this->string(100)->notNull(),
            'shortName' => $this->string(40)->notNull(),
            'value' => $this->string(255)->notNull(),
            'default' => $this->string(255)->notNull(),
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }

}
