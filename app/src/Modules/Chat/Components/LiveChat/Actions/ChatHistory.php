<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 19.10.17
 * Time: 17:38
 */

namespace App\Modules\Chat\Components\LiveChat\Actions;

use App\Modules\Chat\Components\ChatModelFactory;
use Yii;
use yii\db\ActiveRecord;

class ChatHistory
{
    private $pageId;
    private $historyData;

    /**
     * ChatHistory constructor.
     * @param int $pageId
     */
    public function __construct(int $pageId)
    {
        $this->pageId = $pageId;
        $this->historyData = $this->getHistoryData($this->pageId);
    }

    /**
     * @return array
     */
    public function getHistory(): array
    {
        $messages = $this->formatData($this->historyData->chats);
//        $messages  = array_merge($messages, self::getLocalHistory());

        $this->sortMessages($messages);

        return $messages;
    }

    public static function getLocalHistory(): array
    {
        $messagesHistory = [];

        $chatModelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT);
        $messages = $chatModelClass::getNotSendedMessages();

        if ($messages != null) {
            foreach ($messages as $message) {
                $messagesHistory[] = $message->formatMessage();
            }
        }

        return $messagesHistory;
    }

    /**
     * @return int|null
     */
    public function getNextPage(): ?int
    {
        $pageId = $this->pageId;
        $totalPages = $this->historyData->pages;

        if ($this->pageId < $totalPages) {
            return ++$pageId;
        }

        return null;
    }

    /**
     * @param int $pageId
     * @return mixed
     */
    private function getHistoryData(int $pageId)
    {
        return Yii::$app->liveChatApi->getClient()->MyChats->chatHistory(Yii::$app->user->identity->getAddress(), $pageId);
    }

    /**
     * @param array $chats
     * @return array
     */
    private function formatData(array $chats): array
    {
        $messages = [];

        foreach ($chats as $chat) {
            foreach ($chat->messages as $message) {
                $messages[] = (array)$message;
            }
        }

        return $messages;
    }

    /**
     * @param $messages
     */
    private function sortMessages(&$messages): void
    {
        usort($messages, function ($a, $b) {
            if ($a['timestamp'] == $b['timestamp']) {
                return 0;
            }
            return ($a['timestamp'] < $b['timestamp']) ? -1 : 1;
        });
    }

}
