<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 18.10.17
 * Time: 17:52
 */

namespace App\Modules\Chat\Models;


use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use Yii;

class ChatHistory extends \yii\mongodb\ActiveRecord
{
    const DB_DATE_TIME_FORMAT = 'yyyy-MM-dd HH:mm:ss';
    const CREATE = 'createdAt';
    const LAST_UPDATE = 'updatedAt';

    const STATUS_NOT_SENDED = 0;
    const STATUS_SENDED = 1;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $timestampAttributes = [
            'createdAtAttribute' => static::CREATE,
            'updatedAtAttribute' => static::LAST_UPDATE,
        ];

        $behaviors[ 'timestamp' ] = [
            'class' => TimestampBehavior::class,
            'value' => function () {
                return Yii::$app->formatter->asDatetime( time(), self::DB_DATE_TIME_FORMAT );
            },
            'attributes' => [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $timestampAttributes,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $timestampAttributes[ 'updatedAtAttribute' ],
            ]
        ];

        return $behaviors;
    }

    public static function saveMessage(int $chatId, string $message, int $userId): bool
    {
        $model = new self;
        $model->userId = $userId;
        $model->chatId = $chatId;
        $model->message = $message;
        $result = $model->save();

        if (!$result) {
            Yii::error($model->getErrors(), __CLASS__);
        }

        return $result;
    }

    public function getTimestamp()
    {
        return strtotime($this->createdAt);
    }

    public function getDate()
    {
        return date('D, m/d/y g:i:s a', $this->getTimestamp());
    }

    public function formatMessage()
    {
        return [
            'author_name' => 'Client',
            'text' => $this->message,
            'date' => $this->getDate(),
            'timestamp' => $this->getTimestamp(),
            'user_type' => 'visitor',
            'type' => 'message'
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'userId',
            'chatId',
            'status',
            'message',
            'createdAt',
            'updatedAt',
        ];
    }

}
