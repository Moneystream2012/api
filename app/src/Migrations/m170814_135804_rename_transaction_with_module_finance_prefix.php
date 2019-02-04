<?php

use yii\db\Migration;

class m170814_135804_rename_transaction_with_module_finance_prefix extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up(): void
    {
        $this->renameTable('{{%transaction}}', '{{%finance_transaction}}');
    }

    public function down(): void
    {
        $this->renameTable( '{{%finance_transaction}}', '{{%transaction}}');
    }
}
