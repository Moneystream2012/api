<?php

use App\Components\CoreMySQLMigration;

class m170726_114641_user_create_user_sessions_table extends CoreMySQLMigration
{

    public $table = '{{%user_sessions}}';

    public $foreignKeys = [
        [
            'name' => 'fk_user_sessions_user1',
            'table' => '{{%user_sessions}}',
            'columns' => 'userId',
            'refTable' => '{{%user}}',
            'refColumns' => 'id',
            'delete' => self::CASCADE,
            'update' => self::CASCADE,
        ]
    ];

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'id'          => $this->primaryKey()->unsigned(),
            'userId'      => $this->integer(11),
            'userAgent'   => $this->string(),
            'ip'          => $this->string(45),
            'token'       => $this->string(45),
            'sessionTime' => $this->integer()->unsigned(),
            'dateCreated' => $this->dateTime() . ' NOT NULL',
            'dateClosed'  => $this->dateTime() . ' NOT NULL',
        ]);

        $this->createIndex('fk_auth_user_sessions_auth_user1_idx', $this->table, 'userId');
        $this->createForeignKeys();
    }

    public function safeDown():void
    {
        $this->dropForeignKey('fk_user_sessions_user1', $this->table);
        $this->dropIndex('fk_client_sessions_2_idx', $this->table);
        $this->dropIndex('fk_auth_user_sessions_auth_user1_idx', $this->table);
        $this->dropTable($this->table);
    }
}
