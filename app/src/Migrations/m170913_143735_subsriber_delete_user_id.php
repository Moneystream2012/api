<?php

use yii\db\Migration;

class m170913_143735_subsriber_delete_user_id extends Migration
{

    public $table = '{{%subscriber}}';

    public function safeUp()
    {
        $this->dropColumn($this->table, 'userId');
    }

    public function safeDown()
    {
        $this->addColumn($this->table, 'userId', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_143735_subsriber_delete_user_id cannot be reverted.\n";

        return false;
    }
    */
}
