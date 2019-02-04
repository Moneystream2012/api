<?php

use App\Components\CoreMySQLMigration;

class m170704_135561_create_setting_group extends CoreMySQLMigration
{
    public $table = '{{%setting_group}}';


    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(2),
            'name' => $this->string(100)->notNull()->unique(),
            'shortName' => $this->string(20)->notNull()->unique(),
        ]);
    }

}
