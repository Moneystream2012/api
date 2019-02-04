<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 22.09.17
 * Time: 18:27
 */
declare(strict_types=1);

namespace App\Modules\Chat\Controllers\Actions;


use App\Modules\Chat\Components\ChatModelFactory;
use App\Modules\Chat\Components\LiveChat\Actions\ChatHistory;
use App\Modules\Chat\Components\LiveChat\Actions\CreateChat;
use App\Modules\Chat\Components\LiveChatApi\Exceptions\ChatErrorException;
use yii\rest\Action;
use yii\web\NotFoundHttpException;

class ChatPendingAction extends Action
{
    public function run($id)
    {
        $modelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT);
        $model = $modelClass::find()->where(['id' => $id])->one();

        if ($model == null) {
            throw new NotFoundHttpException(404);
        }

        try {
            if ($model->status == $modelClass::STATUS_NOT_CREATED) {

                $chat = new CreateChat();
                if (!$chat->tryResendMessages()) {
                    return ChatHistory::getLocalHistory();
                }

                $model = $modelClass::find()->where(['id' => $id])->one();

                if ($model == null) {
                    throw new NotFoundHttpException(404);
                }
            }

            $apiResult = (array)\Yii::$app->liveChatApi->getClient()->MyChats->chatPending(\Yii::$app->user->identity->getAddress(), $model->securedSessionId);

            if (isset($apiResult['events'])) {
                return $apiResult['events'];
            }
        } catch (ChatErrorException $e) {
            return [];
        }
    }
}
