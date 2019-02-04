<?php

use yii\db\Migration;

class m170814_135801_rename_parking_with_module_finance_prefix extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up(): void
    {
        $this->renameTable('{{%parking}}', '{{%finance_parking}}');
    }

    public function down(): void
    {
        $this->renameTable( '{{%finance_parking}}', '{{%parking}}');
    }
}
