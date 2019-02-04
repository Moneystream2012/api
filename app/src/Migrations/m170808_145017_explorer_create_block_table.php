<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 08.08.17
 */

use App\Components\CoreMySQLMigration;

class m170808_145017_explorer_create_block_table extends CoreMySQLMigration
{
    public $table = '{{%explorer_block}}';


    public function safeUp()
    {
        $this->createNewTable([
            'id' => $this->primaryKey(),
            'hash' => $this->string(64)->unique()->notNull(),
            'height' => $this->integer()->unique()->unsigned()->notNull(),
            'totalAmount' => $this->decimal(16, 8)->notNull()->defaultValue(0),
            'fee' => $this->decimal(16, 8)->notNull()->defaultValue(0),
        ]);
    }
}
