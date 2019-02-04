<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 19:07
 */
declare(strict_types=1);

namespace App\Modules\Chat\Components\LiveChatApi\Model;

use App\Modules\Chat\Components\LiveChatApi\Exceptions\CantSendMessageException;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\ChatErrorException;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\ChatHistoryErrorException;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\ChatNotCreatedException;
use function GuzzleHttp\Psr7\build_query;

class MyChats extends BaseModel
{
    const METHOD_PATH = 'visitors/{:id}/chat';

    /**
     * @param $visitorId
     * @param $welcomMessage
     * @return mixed
     * @throws ChatNotCreatedException
     */
    public function createChat($visitorId, $welcomMessage)
    {
        $url = str_replace('{:id}', $visitorId, self::METHOD_PATH);

        try {
            return $this->executePost($url . '/start', [
                'licence_id' => $this->license,
                'welcome_message' => $welcomMessage
            ]);
        } catch (\Exception $e) {
            throw new ChatNotCreatedException('Cant create chat');
        }
    }

    /**
     * @param $visitorId
     * @param $message
     * @param $securedSessionId
     * @return mixed
     * @throws CantSendMessageException
     */
    public function sendMessage($visitorId, $message, $securedSessionId)
    {
        $url = str_replace('{:id}', $visitorId, self::METHOD_PATH);

        try {
            return $this->executePost($url . '/send_message', [
                'licence_id' => $this->license,
                'message' => $message,
                'secured_session_id' => $securedSessionId,
            ]);
        } catch (\Exception $e) {
            throw new CantSendMessageException('Cant send message.');
        }
    }

    /**
     * @param $visitorId
     * @param $securedSessionId
     * @return mixed
     * @throws ChatErrorException
     */
    public function chatPending($visitorId, $securedSessionId)
    {
        $url = str_replace('{:id}', $visitorId, self::METHOD_PATH);

        $query = build_query([
            'licence_id' => $this->license,
            'secured_session_id' => $securedSessionId,
        ]);

        try {
            return $this->executeGet($url . '/get_pending_messages?'.$query);
        } catch (\Exception $e) {
            throw new ChatErrorException('Cant find chat');
        }
    }

    /**
     * @param $userId
     * @return mixed
     * @throws ChatHistoryErrorException
     */
    public function chatHistory($userId, $page=1)
    {
        $query = build_query([
            'visitor_id' => $this->getVisitorId($userId),
            'page' => $page
        ]);

        try {
            return $this->executeGet( '/chats?'.$query);
        } catch (\Exception $e) {
            throw new ChatHistoryErrorException('Cant find history');
        }
    }

    /**
     * @param $id
     * @return string
     */
    private function getVisitorId($id)
    {
        return $this->license.'.'.$id;
    }

}
