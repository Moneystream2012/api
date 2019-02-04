<?php

use App\Components\CoreMySQLMigration;

class m170704_135567_create_parking_type extends CoreMySQLMigration
{
    public $table = '{{%parking_type}}';


    public function safeUp()
    {
        $this->createNewTable([
            'id' => $this->primaryKey(2),
            'name' => $this->string(50)->notNull(),
            'rate' => $this->float()->notNull(),
            'period' => $this->bigInteger()->notNull(),
        ]);
    }

}
