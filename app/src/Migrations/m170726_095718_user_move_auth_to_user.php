<?php

use yii\db\Migration;

class m170726_095718_user_move_auth_to_user extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up():void
    {
        $this->renameTable('{{%auth_access}}', '{{%user_auth_access}}');
    }

    public function down():void
    {

        $this->renameTable( '{{%user_auth_access}}', '{{%auth_access}}');
    }
}
