<?php

use yii\db\Migration;

class m170913_143746_subsriber_add_email extends Migration
{

    public $table = '{{%subscriber}}';

    public function safeUp()
    {
        $this->addColumn($this->table, 'email', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_143746_subsriber_add_email cannot be reverted.\n";

        return false;
    }
    */
}
