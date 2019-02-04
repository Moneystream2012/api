<?php

use yii\db\Migration;

class m170525_130417_notification_seen_index extends Migration
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
        if (!in_array('notification_seen_index', $tables))  { 
            if ($dbType == "mysql") {
                $this->createTable('{{%notification_seen_index}}', [
                    'user_id' => 'BIGINT(20) NOT NULL',
                    'notification_id' => 'BIGINT(20) NOT NULL',
                ], $tableOptions_mysql);
            }
        }
    }

    public function safeDown()
    {
        echo "m170525_130417_notification_seen_index cannot be reverted.\n";

        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `notification_seen_index`');
        $this->execute('SET foreign_key_checks = 1;');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170525_130417_notification_seen_index cannot be reverted.\n";

        return false;
    }
    */
}
