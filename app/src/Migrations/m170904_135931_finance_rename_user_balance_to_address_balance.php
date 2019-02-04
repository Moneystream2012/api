<?php


use yii\db\Migration;

class m170904_135931_finance_rename_user_balance_to_address_balance extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up(): void
    {
        $this->renameTable('{{%finance_user_balance}}', '{{%finance_address_balance}}');
    }

    public function down(): void
    {
        $this->renameTable( '{{%finance_address_balance}}', '{{%finance_user_balance}}');
    }
}
