<?php


class m170915_093639_subcribe_add_default_source extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%subscribe_source}}';

    public function safeUp()
    {
        $this->insertFirstRecord([
            'name' => 'site',
            'id' => 1
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->table, ['name' => 'site']);
    }


}
