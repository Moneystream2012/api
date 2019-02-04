<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parking_type".
 *
 * @property int $id
 * @property string $rate
 * @property string $title
 * @property int $period
 * @property int $created
 */
class ParkingType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parking_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period', 'created'], 'integer'],
            [['rate'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate' => 'Rate',
            'title' => 'Title',
            'period' => 'Period',
            'created' => 'Created',
        ];
    }
}
