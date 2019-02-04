<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_seen_index".
 *
 * @property int $user_id
 * @property int $notification_id
 */
class NotificationSeenIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_seen_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'notification_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'notification_id' => 'Notification ID',
        ];
    }
}
