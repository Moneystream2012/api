<?php

use yii\db\Migration;

class m170829_135905_explorer_block_add_createdAt_tx_count_fields extends Migration
{
    public $table = '{{%explorer_block}}';


    public function safeUp()
    {
        $this->addColumn($this->table, 'transactions', $this->integer()->notNull()->unsigned()->after('fee'));
        $this->addColumn($this->table, 'createdAt', $this->datetime()->notNull()->after('transactions'));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'createdAt');
        $this->dropColumn($this->table, 'transactions');
    }
}
