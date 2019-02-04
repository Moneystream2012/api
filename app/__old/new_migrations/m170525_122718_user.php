<?php

use yii\db\Migration;

class m170525_122718_user extends Migration
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
		if (!in_array('user', $tables))  { 
		if ($dbType == "mysql") {
			$this->createTable('{{%user}}', [
				'id' => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
				0 => 'PRIMARY KEY (`id`)',
				'address' => 'VARCHAR(255) NOT NULL',
				'verify_address' => 'VARCHAR(255) NOT NULL',
				'password' => 'VARCHAR(255) NOT NULL',
				'balance' => 'VARCHAR(32) NOT NULL',
				'status' => 'INT(1) NOT NULL DEFAULT \'1\'',
				'created' => 'BIGINT(16) NOT NULL',
				'twofa_enabled' => 'TINYINT(1) UNSIGNED NOT NULL',
				'twofa_passed' => 'TINYINT(1) UNSIGNED NOT NULL',
				'twofa_secret' => 'VARCHAR(255) NOT NULL',
				'email_notification' => 'TINYINT(1) UNSIGNED NOT NULL',
				'email' => 'VARCHAR(64) NOT NULL',
				'country' => 'VARCHAR(4) NOT NULL',
				'authKey' => 'VARCHAR(255) NOT NULL',
				'notification_last_id' => 'BIGINT(20) NOT NULL',
			], $tableOptions_mysql);
		}
		}
		 
		 
		$this->createIndex('idx_UNIQUE_id_0885_00','user','id',1);
		 
		$this->execute('SET foreign_key_checks = 0');
		$this->insert('{{%user}}',['id'=>'1','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2','verify_address'=>'','password'=>'10470c3b4b1fed12c3baac014be15fac67c6e815','balance'=>'	   24.12502978','status'=>'1','created'=>'1493310692','twofa_enabled'=>'1','twofa_passed'=>'0','twofa_secret'=>'N5BMZ4N2RTW4MXAN','email_notification'=>'0','email'=>'eqweqw@1.1   ','country'=>'','authKey'=>'','notification_last_id'=>'0']);
		$this->insert('{{%user}}',['id'=>'2','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN3','verify_address'=>'','password'=>'f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','balance'=>'0','	   status'=>'1','created'=>'1493919170','twofa_enabled'=>'0','twofa_passed'=>'0','twofa_secret'=>'','email_notification'=>'0','email'=>'','country'=>'','authKey'=>'','	notification_last_id'=>'0']);
		$this->insert('{{%user}}',['id'=>'3','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN4','verify_address'=>'','password'=>'f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','balance'=>'0','	   status'=>'1','created'=>'1493919226','twofa_enabled'=>'0','twofa_passed'=>'0','twofa_secret'=>'','email_notification'=>'0','email'=>'','country'=>'','authKey'=>'','	notification_last_id'=>'0']);
		$this->insert('{{%user}}',['id'=>'4','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN25','verify_address'=>'','password'=>'7f06c04d59bd83605193621e8d0d693bd30cdc9e','balance'=>'0',	   'status'=>'1','created'=>'1494579293','twofa_enabled'=>'0','twofa_passed'=>'0','twofa_secret'=>'','email_notification'=>'0','email'=>'','country'=>'','authKey'=>'','   notification_last_id'=>'0']);
		$this->insert('{{%user}}',['id'=>'5','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN37','verify_address'=>'','password'=>'10470c3b4b1fed12c3baac014be15fac67c6e815','balance'=>'76'	   ,'status'=>'1','created'=>'1494949449','twofa_enabled'=>'0','twofa_passed'=>'0','twofa_secret'=>'','email_notification'=>'0','email'=>'','country'=>'','authKey'=>'','  notification_last_id'=>'0']);
		$this->insert('{{%user}}',['id'=>'6','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN27','verify_address'=>'','password'=>'10470c3b4b1fed12c3baac014be15fac67c6e815','balance'=>'0',	   'status'=>'0','created'=>'1495553374','twofa_enabled'=>'0','twofa_passed'=>'0','twofa_secret'=>'','email_notification'=>'0','email'=>'','country'=>'','authKey'=>'','   notification_last_id'=>'0']);
		$this->insert('{{%user}}',['id'=>'7','address'=>'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN28','verify_address'=>'','password'=>'10470c3b4b1fed12c3baac014be15fac67c6e815','balance'=>'0',	   'status'=>'0','created'=>'1495553752','twofa_enabled'=>'0','twofa_passed'=>'0','twofa_secret'=>'','email_notification'=>'0','email'=>'','country'=>'','authKey'=>'','   notification_last_id'=>'0']);
		$this->execute('SET foreign_key_checks = 1;');

	}

	public function safeDown()
	{

		$this->execute('SET foreign_key_checks = 0');
		$this->execute('DROP TABLE IF EXISTS `user`');
		$this->execute('SET foreign_key_checks = 1;');

		echo "m170525_122718_user cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m170525_122718_user cannot be reverted.\n";

		return false;
	}
	*/
}
