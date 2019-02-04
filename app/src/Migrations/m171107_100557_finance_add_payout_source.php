<?php


class m171107_100557_finance_add_payout_source extends \App\Components\CoreMySQLMigration
{
    public $table = '{{%finance_payout_source}}';

    private $address = 'XFc69R5rMy5S1AVh7D6Gg2Ttwo9u6wRCsP';

    public function safeUp()
    {
        $this->insert($this->table, [
            'address' => $this->address,
            'createdAt' => Yii::$app->formatter->asDatetime(time(), static::DATE_FORMAT),
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->table, ['address' => $this->address]);
    }
}
