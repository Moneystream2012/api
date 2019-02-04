<?php


use App\Components\CoreMySQLMigration;

class m170807_135800_create_finance_payout_source extends CoreMySQLMigration
{
    public $table = '{{%finance_payout_source}}';


    public function safeUp()
    {
        $this->createNewTable([
            'id' => $this->primaryKey(),
            'address' => $this->string(40)->notNull()->unique(),
            'createdAt' => $this->datetime()->notNull(),
        ]);
    }
}
