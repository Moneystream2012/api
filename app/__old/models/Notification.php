<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $title
 * @property string $content
 * @property int $seen
 * @property string $created
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'seen', 'created'], 'integer'],
            [['created'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'title' => 'Title',
            'content' => 'Content',
            'seen' => 'Seen',
            'created' => 'Created',
        ];
    }
}
