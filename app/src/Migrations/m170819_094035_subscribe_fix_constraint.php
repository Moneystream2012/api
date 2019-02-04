<?php

use yii\db\Migration;

class m170819_094035_subscribe_fix_constraint extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
		$this->dropForeignKey('fk_subscriber_1', '{{%subscriber}}');
		$this->addForeignKey(
			'fk_subscriber_1',
			'{{%subscriber}}',
			'sourceId',
			'{{%subscribe_source}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
    }

    public function down()
    {
	    $this->dropForeignKey('fk_subscriber_1', '{{%subscriber}}');
	    $this->addForeignKey(
		    'fk_subscriber_1',
		    '{{%subscriber}}',
		    'sourceId',
		    '{{%subscribe_source}}',
		    'id',
		    'RESTRICT',
		    'CASCADE'
	    );
    }
}
