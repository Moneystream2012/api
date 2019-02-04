<?php


use App\Components\CoreMySQLMigration;

class m170704_135554_create_auth_access extends CoreMySQLMigration
{
    public $table = '{{%auth_access}}';

    public $indexes = [ 'userId' ];


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'address' => $this->string(40)->notNull()->unique(),
            'sign' => $this->string(88)->notNull(),
            'secretWord' => $this->string(45)->notNull(),
            'tfauthCode' => $this->string(10)->notNull()->defaultValue(''),
            'tfauthActive' => $this->integer(1)->notNull()->defaultValue(0),
            'lastEnter' => $this->datetime()->notNull(),
        ]);
    }

}
