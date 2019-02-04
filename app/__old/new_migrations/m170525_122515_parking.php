<?php

use yii\db\Migration;

class m170525_122515_parking extends Migration
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
		if (!in_array('parking', $tables))  { 
		if ($dbType == "mysql") {
			$this->createTable('{{%parking}}', [
				'id' => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
				0 => 'PRIMARY KEY (`id`)',
				'user_id' => 'BIGINT(20) UNSIGNED NOT NULL',
				'type' => 'INT(1) UNSIGNED NOT NULL',
				'rate' => 'VARCHAR(8) NOT NULL',
				'amount' => 'VARCHAR(32) NOT NULL',
				'info' => 'VARCHAR(1024) NOT NULL',
				'status' => 'INT(1) NOT NULL',
				'created' => 'BIGINT(16) NOT NULL',
				'expired' => 'BIGINT(16) NOT NULL',
				'device' => 'VARCHAR(255) NOT NULL',
			], $tableOptions_mysql);
		}
		}
		 
		 
		$this->createIndex('idx_UNIQUE_id_8664_00','parking','id',1);
		$this->createIndex('idx_user_id_8664_01','parking','user_id',0);
		 
		$this->execute('SET foreign_key_checks = 0');
		$this->addForeignKey('fk_user_8652_00','{{%parking}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'NO ACTION' );
		$this->execute('SET foreign_key_checks = 1;');
		 
		$this->execute('SET foreign_key_checks = 0');
		$this->insert('{{%parking}}',['id'=>'5','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1493917216','expired'=>'1493917266','device'	 =>'web']);
		$this->insert('{{%parking}}',['id'=>'6','user_id'=>'3','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1493919289','expired'=>'1494005689','device'	 =>'web']);
		$this->insert('{{%parking}}',['id'=>'7','user_id'=>'3','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1493919294','expired'=>'1494005694','device'	 =>'web']);
		$this->insert('{{%parking}}',['id'=>'8','user_id'=>'3','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1493919297','expired'=>'1494005697','device'	 =>'web']);
		$this->insert('{{%parking}}',['id'=>'9','user_id'=>'3','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1493919298','expired'=>'1494005698','device'	 =>'web']);
		$this->insert('{{%parking}}',['id'=>'10','user_id'=>'3','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1493919298','expired'=>'1494005698','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'11','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001371','expired'=>'1494087771','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'12','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001376','expired'=>'1494087776','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'13','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001378','expired'=>'1494087778','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'14','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001378','expired'=>'1494087778','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'15','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001378','expired'=>'1494087778','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'16','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001378','expired'=>'1494087778','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'17','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001379','expired'=>'1494087779','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'18','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'1','info'=>'','status'=>'1','created'=>'1494001381','expired'=>'1494087781','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'19','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001381','expired'=>'1494087781','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'20','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001382','expired'=>'1494087782','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'21','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001382','expired'=>'1494087782','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'22','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001383','expired'=>'1494087783','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'23','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001383','expired'=>'1494087783','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'24','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001384','expired'=>'1494087784','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'25','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001385','expired'=>'1494087785','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'28','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001385','expired'=>'1494087785','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'29','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'02','info'=>'','status'=>'1','created'=>'1494001386','expired'=>'1494087786','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'34','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001388','expired'=>'1494087788','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'37','user_id'=>'1','type'=>'2','rate'=>'17','amount'=>'0','info'=>'','status'=>'1','created'=>'1494001389','expired'=>'1494087789','device'		=>'web']);
		$this->insert('{{%parking}}',['id'=>'157','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128416','expired'=>'1495214816','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'158','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128427','expired'=>'1495214827','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'159','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128454','expired'=>'1495214854','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'160','user_id'=>'5','type'=>'3','rate'=>'35','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128524','expired'=>'1497720524','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'161','user_id'=>'5','type'=>'2','rate'=>'23','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128545','expired'=>'1495733345','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'162','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128579','expired'=>'1495214979','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'163','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'123','info'=>'','status'=>'0','created'=>'1495128924','expired'=>'1495215324','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'164','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'100','info'=>'','status'=>'0','created'=>'1495128992','expired'=>'1495215392','		device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'165','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129086','expired'=>'1495215486','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'166','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129088','expired'=>'1495215488','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'167','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129088','expired'=>'1495215488','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'168','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129088','expired'=>'1495215488','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'169','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129089','expired'=>'1495215489','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'170','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129089','expired'=>'1495215489','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'171','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129089','expired'=>'1495215489','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'172','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129089','expired'=>'1495215489','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'173','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129090','expired'=>'1495215490','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'174','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129090','expired'=>'1495215490','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'175','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129154','expired'=>'1495215554','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'176','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129167','expired'=>'1495215567','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'177','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129178','expired'=>'1495215578','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'178','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'3','info'=>'','status'=>'0','created'=>'1495129198','expired'=>'1495215598','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'181','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'1','info'=>'','status'=>'0','created'=>'1495129529','expired'=>'1495215929','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'182','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'1','info'=>'','status'=>'0','created'=>'1495129591','expired'=>'1495215991','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'183','user_id'=>'5','type'=>'2','rate'=>'23','amount'=>'10','info'=>'','status'=>'0','created'=>'1495129688','expired'=>'1495734488','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'184','user_id'=>'5','type'=>'2','rate'=>'23','amount'=>'10','info'=>'','status'=>'0','created'=>'1495129700','expired'=>'1495734500','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'185','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'12','info'=>'','status'=>'0','created'=>'1495129822','expired'=>'1495216222','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'186','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'12','info'=>'','status'=>'0','created'=>'1495129845','expired'=>'1495216245','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'187','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'12','info'=>'','status'=>'0','created'=>'1495129900','expired'=>'1495216300','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'188','user_id'=>'5','type'=>'1','rate'=>'17','amount'=>'12','info'=>'','status'=>'0','created'=>'1495129909','expired'=>'1495216309','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'191','user_id'=>'1','type'=>'1','rate'=>'17','amount'=>'1.0E-6','info'=>'','status'=>'0','created'=>'1495198149','expired'=>'1495284549','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'193','user_id'=>'1','type'=>'1','rate'=>'17','amount'=>'1','info'=>'','status'=>'1','created'=>'1495216973','expired'=>'1495303373','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'194','user_id'=>'1','type'=>'1','rate'=>'17','amount'=>'5','info'=>'','status'=>'1','created'=>'1495217702','expired'=>'1495304101','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'195','user_id'=>'1','type'=>'3','rate'=>'35','amount'=>'250000','info'=>'','status'=>'2','created'=>'1495217808','expired'=>'1497809808','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'196','user_id'=>'1','type'=>'1','rate'=>'17','amount'=>'50','info'=>'','status'=>'1','created'=>'1495217863','expired'=>'1495304263','	 device'=>'web']);
		$this->insert('{{%parking}}',['id'=>'197','user_id'=>'1','type'=>'2','rate'=>'23','amount'=>'1','info'=>'','status'=>'2','created'=>'1495218048','expired'=>'1495822848','device		'=>'web']);
		$this->insert('{{%parking}}',['id'=>'198','user_id'=>'1','type'=>'1','rate'=>'17','amount'=>'5','info'=>'','status'=>'1','created'=>'1495218556','expired'=>'1495304956','device		'=>'web']);
		$this->execute('SET foreign_key_checks = 1;');

	}

	public function safeDown()
	{

		$this->execute('SET foreign_key_checks = 0');
		$this->execute('DROP TABLE IF EXISTS `parking`');
		$this->execute('SET foreign_key_checks = 1;');

		echo "m170525_122515_parking cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m170525_122515_parking cannot be reverted.\n";

		return false;
	}
	*/
}
