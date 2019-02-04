<?php

use yii\db\Migration;

class m170801_125400_user_add_default_value extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('minex_user', 'username', $this->string(100)->notNull()->defaultValue(''));
        $this->alterColumn('minex_user', 'email', $this->string(100)->notNull()->defaultValue('')->unique());
        $this->alterColumn('minex_user', 'phone', $this->string(30)->notNull()->defaultValue('')->unique());
        $this->alterColumn('minex_user', 'countryCode', $this->string(3)->notNull()->defaultValue(''));

        $this->alterColumn('minex_user', 'active', $this->integer()->notNull()->defaultValue(1));
        $this->alterColumn('minex_user', 'notification', $this->integer()->notNull()->defaultValue(1));

        $this->alterColumn('minex_user_auth_access', 'tfauthCode', $this->string(10)->notNull()->defaultValue(1));
        $this->alterColumn('minex_user_auth_access', 'tfauthActive', $this->boolean()->notNull()->defaultValue(1));

        $this->dropColumn('minex_user_auth_access','secretWord');
    }

    public function safeDown()
    {

    }
}
