<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 08.08.17
 */

use App\Components\CoreMySQLMigration;

class m170808_154305_explorer_create_output_table extends CoreMySQLMigration
{
    public $table = '{{%explorer_output}}';

    public $indexes = [ 'transactionId', 'address' ];

    public function safeUp()
    {
        $this->createNewTableWithIndexes([
            'id' => $this->primaryKey(),
            'transactionId' => $this->string(64)->notNull()->defaultValue('-'),
            'amount' => $this->decimal(16, 8)->unsigned()->notNull()->defaultValue(0),
            'address' => $this->string(35)->notNull()->defaultValue('-'),
        ]);
    }
}