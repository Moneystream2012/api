<?php

use yii\db\Migration;

class m171018_111051_add_chat_history_table extends \yii\mongodb\Migration
{
    public $collection = 'chat_history';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Yii::$app->mongodb;
        parent::init();
    }

    public function up()
    {
        $this->createCollection($this->collection);
        $this->insert($this->collection, [
            'userId' => 0,
            'chatId' => 0,
            'status' => 0,
            'message' => '',
            'createdAt' => '',
            'updatedAt' => '',
        ]);
        $this->createIndex($this->collection, ['userId', 'chatId']);
    }

    public function down()
    {
        $this->dropCollection($this->collection);
    }
}
