<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payout".
 *
 * @property string $id
 * @property string $parking_id
 * @property string $transaction_id
 * @property string $user_id
 * @property string $amount
 * @property string $created
 *
 * @property Parking $parking
 * @property User $user
 */
class Payout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parking_id', 'user_id', 'created'], 'integer'],
            [['transaction_id'], 'string', 'max' => 255],
            [['amount'], 'string', 'max' => 32],
            [['parking_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parking::className(), 'targetAttribute' => ['parking_id' => 'id']],
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
            'parking_id' => 'Parking ID',
            'transaction_id' => 'Transaction ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['id' => 'parking_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
