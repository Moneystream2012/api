<?php


use App\Components\CoreMySQLMigration;

class m170704_135560_create_subscribe_message extends CoreMySQLMigration
{
    public $table = '{{%subscribe_message}}';

    public $indexes = [ 'authorId', 'groupId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'content' => $this->text()->notNull(),
            'authorId' => $this->integer()->notNull(),
            'groupId' => $this->integer(2)->notNull(),
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }

}
