<?php

use App\Components\CoreMySQLMigration;
use yii\db\Migration;

class m170829_072152_chnage_index_for_user_table extends CoreMySQLMigration
{

    public $table = '{{%user}}';


    public function safeUp()
    {
        $this->dropIndex('email', $this->table);
        $this->dropIndex('phone', $this->table);
    }

    public function safeDown()
    {
        $this->createIndex('email', $this->table, ['email'], true);
        $this->createIndex('phone', $this->table, ['phone'], true);
    }

}
