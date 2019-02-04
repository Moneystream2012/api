<?php

class m171006_125441_user_add_columns_to_user_auth_access extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%user_auth_access}}';

    protected $indexes = ['resetToken'];

    public function safeUp()
    {
        $this->addTableColumns([
            [
                'name' => 'resetToken',
                'type' => $this->string(40)->notNull()->defaultValue('')
            ],
            [
                'name' => 'resetTokenExpired',
                'type' => $this->dateTime()->notNull()->defaultValue(Yii::$app->formatter->asDatetime(time(), parent::DATE_FORMAT))
            ]
        ])
        ->createTableIndexes();
    }

    public function safeDown()
    {
        $this->dropTableColumns(['resetToken', 'resetTokenExpired'])
        ->dropTableIndexes();
    }
}
