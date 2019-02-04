<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_message".
 *
 * @property string $id
 * @property string $room_id
 * @property string $user_id
 * @property int $user_seen
 * @property int $support_seen
 * @property string $message
 * @property string $created
 *
 * @property SupportRoom $room
 * @property User $user
 */
class SupportMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'user_id', 'user_seen', 'support_seen', 'created'], 'integer'],
            [['message'], 'string', 'max' => 1024],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupportRoom::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'user_id' => 'User ID',
            'user_seen' => 'User Seen',
            'support_seen' => 'Support Seen',
            'message' => 'Message',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(SupportRoom::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
