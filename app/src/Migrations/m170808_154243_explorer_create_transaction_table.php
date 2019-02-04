<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 08.08.17
 */

use App\Components\CoreMySQLMigration;

class m170808_154243_explorer_create_transaction_table extends CoreMySQLMigration
{
    public $table = '{{%explorer_transaction}}';

    public $indexes = [ 'block' ];

    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'hash' => $this->string(64)->unique()->notNull(),
            'block' => $this->string(64)->notNull()->defaultValue(''),
            'amount' => $this->decimal(16, 8)->notNull()->defaultValue(0),
            'fee' => $this->decimal(16, 8)->notNull()->defaultValue(0),
        ]);
    }
}
