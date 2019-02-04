<?php

use yii\db\Migration;

class m170829_135906_explorer_transaction_add_index_field extends Migration
{
    public $table = '{{%explorer_transaction}}';


    public function safeUp()
    {
        $this->addColumn($this->table, 'index', $this->integer()->notNull()->unsigned()->after('fee'));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'index');
    }
}
