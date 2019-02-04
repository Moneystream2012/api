<?php

use yii\db\Migration;

class m170821_063536_rename_template_to_mail extends Migration
{
    public function safeUp()
    {
		$this->renameTable('{{%template}}','{{%mail_template}}');
    }

    public function safeDown()
    {
	    $this->renameTable('{{%mail_template}}','{{%template}}');
    }

}
