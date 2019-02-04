<?php

use yii\db\Migration;

class m170814_135805_rename_transaction_log_with_module_finance_prefix extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up(): void
    {
        $this->renameTable('{{%transaction_log}}', '{{%finance_transaction_log}}');
    }

    public function down(): void
    {
        $this->renameTable( '{{%finance_transaction_log}}', '{{%transaction_log}}');
    }
}
