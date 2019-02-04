<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parking".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $type
 * @property string $rate
 * @property string $amount
 * @property string $info
 * @property integer $status
 * @property integer $created
 * @property integer $expired
 * @property string $device
 *
 * @property User $user
 * @property Payout[] $payouts
 */
class Parking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'status', 'created', 'expired'], 'integer'],
            [['expired', 'device'], 'required'],
            [['rate'], 'string', 'max' => 8],
            [['amount'], 'string', 'max' => 32],
            [['info'], 'string', 'max' => 1024],
            [['device'], 'string', 'max' => 255],
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
            'type_id' => 'Type ID',
            'rate' => 'Rate',
            'amount' => 'Amount',
            'info' => 'Info',
            'status' => 'Status',
            'created' => 'Created',
            'expired' => 'Expired',
            'device' => 'Device',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayouts()
    {
        return $this->hasMany(Payout::className(), ['parking_id' => 'id']);
    }
}