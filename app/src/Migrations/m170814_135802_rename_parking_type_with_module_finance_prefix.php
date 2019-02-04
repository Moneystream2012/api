<?php

use yii\db\Migration;

class m170814_135802_rename_parking_type_with_module_finance_prefix extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up(): void
    {
        $this->renameTable('{{%parking_type}}', '{{%finance_parking_type}}');
    }

    public function down(): void
    {
        $this->renameTable( '{{%finance_parking_type}}', '{{%parking_type}}');
    }
}
