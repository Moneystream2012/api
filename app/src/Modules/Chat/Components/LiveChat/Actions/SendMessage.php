<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 19.10.17
 * Time: 12:19
 */

namespace App\Modules\Chat\Components\LiveChat\Actions;


use App\Modules\Chat\Components\ChatModelFactory;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\CantSendMessageException;
use App\Modules\Chat\Models\Chat;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use Yii;

class SendMessage
{
    /**
     * @var \App\Modules\Chat\Models\Chat
     */
    private $chatModelClass;

    /**
     * @var \App\Modules\Chat\Models\ChatHistory
     */
    private $chatHistoryModelClass;

    private $chatId;
    private $message;

    const SUCCESS_RESULT = 1;

    /**
     * SendMessage constructor.
     * @param int $chatId
     * @param string $message
     */
    public function __construct(int $chatId, string $message)
    {
        $this->chatId = $chatId;
        $this->message = $message;

        $this->chatModelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT);
        $this->chatHistoryModelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT_HISTORY);
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function send(): void
    {
        $chatModel = $this->getChatModel();

        try {
            $this->saveMessage($chatModel->id);

            if ($chatModel->status == Chat::STATUS_CREATED) {
                $this->sendMessageToApi($chatModel->securedSessionId);
            }

        } catch (CantSendMessageException $e) {
            Yii::error('Cant save message', __CLASS__);
            throw new ServerErrorHttpException('Cant save message');
        }
    }

    /**
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    private function getChatModel(): ActiveRecord
    {
        $chatModel = $this->chatModelClass::getModelByMessageId($this->chatId);

        if ($chatModel == null) {
            throw new NotFoundHttpException('Cant find chat model with this id.');
        }

        return $chatModel;
    }

    /**
     * @param int $chatId
     * @throws CantSendMessageException
     */
    private function saveMessage(int $chatId): void
    {
        $result = $this->chatHistoryModelClass::saveMessage($chatId, $this->message, Yii::$app->user->id);

        if ($result == false) {
            throw new CantSendMessageException('Cant save message to db');
        }
    }

    /**
     * @param string $securedSessionId
     * @return bool
     * @throws CantSendMessageException
     */
    public function sendMessageToApi(string $securedSessionId): bool
    {
        $apiResult = Yii::$app->liveChatApi->getClient()->MyChats->sendMessage(
            Yii::$app->user->identity->getAddress(),
            $this->message,
            $securedSessionId
        );


        if ($apiResult->success != self::SUCCESS_RESULT) {
            throw new CantSendMessageException('Cant send message to api');
        }

        return true;
    }
}
