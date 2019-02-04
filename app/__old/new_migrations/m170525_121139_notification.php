<?php

use yii\db\Migration;

class m170525_121139_notification extends Migration
{
	public function safeUp()
	{

		$tables = Yii::$app->db->schema->getTableNames();
		$dbType = $this->db->driverName;
		$tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
		$tableOptions_mssql = "";
		$tableOptions_pgsql = "";
		$tableOptions_sqlite = "";
		/* MYSQL */
		if (!in_array('notification', $tables))  { 
		if ($dbType == "mysql") {
			$this->createTable('{{%notification}}', [
				'id' => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
				0 => 'PRIMARY KEY (`id`)',
				'user_id' => 'BIGINT(20) UNSIGNED NOT NULL',
				'type' => 'INT(1) UNSIGNED NOT NULL',
				'title' => 'VARCHAR(255) NOT NULL',
				'content' => 'VARCHAR(1024) NOT NULL',
				'seen' => 'TINYINT(1) UNSIGNED NOT NULL',
				'created' => 'BIGINT(16) NOT NULL',
			], $tableOptions_mysql);
		}
		}
		 
		 
		$this->createIndex('idx_UNIQUE_id_3407_00','notification','id',1);
		 
		$this->execute('SET foreign_key_checks = 0');
		$this->insert('{{%notification}}',['id'=>'3','user_id'=>'5','type'=>'0','title'=>'2','content'=>'2','seen'=>'0','created'=>'1494947535']);
		$this->insert('{{%notification}}',['id'=>'59','user_id'=>'0','type'=>'0','title'=>'qwe','content'=>'qwe','seen'=>'0','created'=>'1495463482']);
		$this->insert('{{%notification}}',['id'=>'60','user_id'=>'0','type'=>'0','title'=>'123','content'=>'123','seen'=>'0','created'=>'1495476723']);
		$this->insert('{{%notification}}',['id'=>'61','user_id'=>'0','type'=>'0','title'=>'12312','content'=>'3123123','seen'=>'0','created'=>'1495626685']);
		$this->insert('{{%notification}}',['id'=>'62','user_id'=>'0','type'=>'0','title'=>'1','content'=>'1','seen'=>'0','created'=>'1495627054']);
		$this->insert('{{%notification}}',['id'=>'63','user_id'=>'0','type'=>'0','title'=>'111','content'=>'111','seen'=>'0','created'=>'1495640340']);
		$this->execute('SET foreign_key_checks = 1;');
	
	}

	public function safeDown()
	{

		$this->execute('SET foreign_key_checks = 0');
		$this->execute('DROP TABLE IF EXISTS `notification`');
		$this->execute('SET foreign_key_checks = 1;');

		echo "m170525_121139_notification cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m170525_121139_notification cannot be reverted.\n";

		return false;
	}
	*/
}
