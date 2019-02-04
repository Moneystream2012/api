<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $id
 * @property string $k
 * @property string $v
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['k'], 'required'],
            [['k'], 'string', 'max' => 255],
            [['v'], 'string', 'max' => 1024],
            [['k'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'k' => 'K',
            'v' => 'V',
        ];
    }
}
