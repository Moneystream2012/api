<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 22.09.17
 * Time: 17:01
 */

namespace App\Modules\Chat\Controllers\Actions;


use App\Modules\Chat\Components\LiveChat;
use App\Modules\Chat\Models\ChatMessage;
use yii\rest\Action;
use \Yii;

class CreateMessageAction extends Action
{

    public function run()
    {
        $chatMessage = new ChatMessage();

        if ($chatMessage->load(Yii::$app->request->post(), '') && $chatMessage->validate()) {
            Yii::$app->liveChat->sendMessage($chatMessage->chatId, $chatMessage->message);
        }

        return $chatMessage;
    }
}
