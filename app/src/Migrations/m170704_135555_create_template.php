<?php


use App\Components\CoreMySQLMigration;

class m170704_135555_create_template extends CoreMySQLMigration
{
    public $table = '{{%template}}';


    public function safeUp()
    {
        $this->createNewTable([
            'id' => $this->primaryKey(3),
            'name' => $this->string(100)->notNull(),
            'content' => $this->text()->notNull(),
            'createdAt' => $this->datetime()->notNull(),
            'updatedAt' => $this->datetime()->notNull(),
            'authorId' => $this->integer()->notNull(),
            'moderatorId' => $this->integer()->notNull(),
        ]);
    }

}
