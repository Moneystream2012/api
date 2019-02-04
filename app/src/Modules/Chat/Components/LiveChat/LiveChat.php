<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 19.10.17
 * Time: 12:14
 */

namespace App\Modules\Chat\Components\LiveChat;
use App\Modules\Chat\Components\LiveChat\Actions\ChatHistory;
use App\Modules\Chat\Components\LiveChat\Actions\CreateChat;
use App\Modules\Chat\Components\LiveChat\Actions\SendMessage;
use yii\base\Component;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class LiveChat
 * @package App\Modules\Chat\Components\LiveChat
 */
class LiveChat extends Component
{

    /**
     * @param int $chatId
     * @param string $message
     */
    public function sendMessage(int $chatId, string $message): void
    {
        $action = new SendMessage($chatId, $message);
        $action->send();
    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function createChat(): ActiveRecord
    {
        $action = new CreateChat();
        return $action->create();
    }

    /**
     * @param $pageId
     * @return array
     */
    public function getHistory($pageId): array
    {
        $action = new ChatHistory($pageId);

        $nextPageUrl = null;

        if ($action->getNextPage() != null) {
            $nextPageUrl = Url::to(['/chat/chat-history', 'page' => $action->getNextPage()]);
        }

        return [
            'messages'  => $action->getHistory(),
            'nextPage' => $nextPageUrl
        ];
    }
}
