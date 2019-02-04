<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 19.10.17
 * Time: 12:30
 */

namespace App\Modules\Chat\Components\LiveChat\Actions;


use App\Modules\Chat\Components\ChatModelFactory;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\ChatErrorException;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\ChatNotCreatedException;
use App\Modules\Chat\Models\Chat;
use yii\base\ErrorException;
use yii\db\ActiveRecord;

class CreateChat
{
    /**
     * @var \App\Modules\Chat\Models\Chat
     */
    public $chatModelClass;

    /**
     * @var \App\Modules\Chat\Models\ChatHistory
     */
    public $chatHistoryModelClass;

    public function __construct()
    {
        $this->chatModelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT);
        $this->chatHistoryModelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT_HISTORY);
    }

    /**
     * @return ActiveRecord
     * @throws ErrorException
     */
    public function create(): ActiveRecord
    {
        try {
            return $this->createChat();
        } catch (ChatNotCreatedException $e) {
            return $this->saveNotCreatedChat();
        } catch (ChatErrorException $e) {
            throw new ErrorException('Cant create chat');
        }
    }

    /**
     * @return ActiveRecord
     */
    private function createChat(): ActiveRecord
    {
        $securedSessionId = $this->sendCreateChatToApi();

        if (is_null($securedSessionId)) {
            return $this->getLastChat();
        }

        $chatModel = $this->saveCreatedChat($securedSessionId);
        $this->sendNotSendedMessages($chatModel);
        return $chatModel;
    }

    /**
     * @param ActiveRecord $chatModel
     */
    private function sendNotSendedMessages(ActiveRecord $chatModel)
    {
        $notCreatedChatModel = $this->chatModelClass::getNotCreatedChat();

        if ($notCreatedChatModel != null) {
            $messagesModel = $this->chatHistoryModelClass::find()->where(['chatId' => $notCreatedChatModel->id])->all();

            foreach ($messagesModel as $messageModel) {
                $action = new SendMessage($messageModel->chatId, $messageModel->message);
                $action->sendMessageToApi($chatModel->securedSessionId);
            }

            $notCreatedChatModel->securedSessionId = $chatModel->securedSessionId;
            $notCreatedChatModel->status = $this->chatModelClass::STATUS_CREATED;
            $notCreatedChatModel->save();
        }
    }

    /**
     * @return null|string
     */
    private function sendCreateChatToApi(): ?string
    {
        $apiResult = \Yii::$app->liveChatApi->getClient()->MyChats->createChat(
            \Yii::$app->user->identity->getAddress(),
            \Yii::$app->params['liveChat']['welcomeMessage']
        );

        if (!empty($apiResult->secured_session_id)) {
            return $apiResult->secured_session_id;
        }

        return null;
    }

    /**
     * @param string $apiResult
     * @return ActiveRecord
     */
    private function saveCreatedChat(string $apiResult): ActiveRecord
    {
        $notCreatedChatModel = $this->chatModelClass::getNotCreatedChat();

        if ($notCreatedChatModel != null) {
            $notCreatedChatModel->securedSessionId = $apiResult;
            $notCreatedChatModel->save();
            return $notCreatedChatModel;
        }

        return $this->saveChat($apiResult, $this->chatModelClass::STATUS_CREATED);
    }

    /**
     * @return ActiveRecord
     */
    private function saveNotCreatedChat(): ActiveRecord
    {
        $notCreatedChatModel = $this->chatModelClass::getNotCreatedChat();

        // якщо для цього користувача, вже був створений чат в офілайні - використовуємо цей чат
        if ($notCreatedChatModel != null) {
            return $this->chatModelClass::getLastChat();
        }

        return $this->saveChat(null, $this->chatModelClass::STATUS_NOT_CREATED);
    }

    /**
     * @param null|string $chatId
     * @param int $status
     * @return ActiveRecord
     * @throws ChatNotCreatedException
     */
    private function saveChat(?string $chatId, int $status): ActiveRecord
    {
        $result = $this->chatModelClass::saveChat($chatId, $status, \Yii::$app->user->id);

        if ($result->getErrors()) {
            throw new ChatNotCreatedException('Cant save message to db');
        }

        return $result;
    }

    /**
     * @return ActiveRecord
     */
    private function getLastChat(): ActiveRecord
    {
        $chatModel = $this->chatModelClass::getLastChat();

        if ($chatModel == null) {
            return $this->saveChat(null, $this->chatModelClass::STATUS_NOT_CREATED);
        }

        return $chatModel;
    }

    /**
     * @return bool
     */
    public function tryResendMessages(): bool
    {
        try {
            $notCreatedChatModel = $this->chatModelClass::getNotCreatedChat();

            if ($notCreatedChatModel != null) {
                $securedSessionId = $this->sendCreateChatToApi();

                if (!is_null($securedSessionId)) {
                    $chatModel = $this->saveCreatedChat($securedSessionId);
                    $this->sendNotSendedMessages($chatModel);
                }
            }

            return true;
        } catch (ChatNotCreatedException $e) {
            return false;
        }
    }
}
