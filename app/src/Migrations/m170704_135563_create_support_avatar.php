<?php


use App\Components\CoreMySQLMigration;

class m170704_135563_create_support_avatar extends CoreMySQLMigration
{
    public $table = '{{%support_avatar}}';

    public $indexes = [ 'userId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'filename' => $this->string(200)->notNull(),
        ]);
    }

}
