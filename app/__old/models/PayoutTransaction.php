<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payout_transaction".
 *
 * @property int $id
 * @property int $parking_id
 * @property string $txid
 * @property int $created
 * @property int $spended
 */
class PayoutTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payout_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parking_id', 'created', 'spended'], 'integer'],
            [['txid'], 'required'],
            [['txid'], 'string', 'max' => 255],
            [['txid'], 'unique'],
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
            'txid' => 'Txid',
            'created' => 'Created',
            'spended' => 'Spended',
        ];
    }
}
