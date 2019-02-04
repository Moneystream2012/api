<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 18:19
 */
declare(strict_types=1);

namespace App\Modules\Chat\Models;
use App\Modules\Chat\Components\ChatModelFactory;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class Chat extends \App\Modules\Database\Chat
{
    const STATUS_NOT_CREATED = 0;
    const STATUS_CREATED = 1;


    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['securedSessionId'], 'string', 'max' => 255],
        ];
    }

    public static function getLastChat() : ActiveRecord
    {
        return self::find()->where(['userId' => \Yii::$app->user->id])->orderBy(['updatedAt' => SORT_DESC])->limit(1)->one();
    }

    public static function getModelByMessageId(int $id): ?ActiveRecord
    {
        return self::find()->where(['id' => $id])->one();
    }

    public static function saveChat(?string $chatId, int $status, int $userId): ActiveRecord
    {
        $model = new self;
        $model->securedSessionId = $chatId;
        $model->status = $status;
        $model->userId = $userId;
        $model->save();

        return $model;
    }

    public static function getNotCreatedChat(): ?ActiveRecord
    {
        return self::find()->where([
            'status' => self::STATUS_NOT_CREATED,
            'userId' => \Yii::$app->user->id,
        ])->one();
    }

    public static function getNotSendedMessages(): ?array
    {
        $notCreatedChatModel = self::getNotCreatedChat();
        $chatHistoryModelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT_HISTORY);

        if ($notCreatedChatModel != null) {
            return $chatHistoryModelClass::find()->where(['chatId' => $notCreatedChatModel->id])->all();
        }

        return null;
    }

    public function fields() : array
    {
        return [
            'id',
            'userId',
            'securedSessionId',
            'createdAt',
            'updatedAt'
        ];
    }

}
