<?php

use yii\db\Migration;

class m170814_135803_rename_parking_log_with_module_finance_prefix extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up(): void
    {
        $this->renameTable('{{%parking_log}}', '{{%finance_parking_log}}');
    }

    public function down(): void
    {
        $this->renameTable( '{{%finance_parking_log}}', '{{%parking_log}}');
    }
}
