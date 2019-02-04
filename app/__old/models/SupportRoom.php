<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_room".
 *
 * @property string $id
 * @property string $user_id
 * @property string $support_id
 * @property string $status
 * @property string $created
 * @property string $closed
 *
 * @property SupportMessage[] $supportMessages
 * @property User $support
 * @property User $user
 */
class SupportRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'support_id', 'status', 'created', 'closed'], 'integer'],
            [['support_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['support_id' => 'id']],
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
            'user_id' => 'User ID',
            'support_id' => 'Support ID',
            'status' => 'Status',
            'created' => 'Created',
            'closed' => 'closed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupportMessages()
    {
        return $this->hasMany(SupportMessage::className(), ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupport()
    {
        return $this->hasOne(User::className(), ['id' => 'support_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
