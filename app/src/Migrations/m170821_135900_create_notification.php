<?php

/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 27.07.17
 */

class m170821_135900_create_notification extends \yii\mongodb\Migration
{
    public $collection = 'notification';

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
            'title' => '',
            'content' => '',
            'type' => '',
            'postedFor' => [],
            'seenBy' => [],
            'authorId' => 0,
            'moderatorId' => 0,
            'createdAt' => '',
            'updatedAt' => '',
        ]);
        $this->createIndex($this->collection, ['type', 'moderatorId']);
    }

    public function down()
    {
        $this->dropCollection($this->collection);
    }
}
