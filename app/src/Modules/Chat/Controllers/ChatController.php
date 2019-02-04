<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 17:50
 */
declare(strict_types=1);

namespace App\Modules\Chat\Controllers;
use App\Components\RestController;
use App\Helpers\Arr;
use App\Modules\Chat\Components\ChatModelFactory;
use App\Modules\Chat\Controllers\Actions\ChatHistoryAction;
use App\Modules\Chat\Controllers\Actions\ChatPendingAction;
use App\Modules\Chat\Controllers\Actions\CreateChatAction;
use App\Modules\Chat\Controllers\Actions\CreateMessageAction;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ChatController extends RestController
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->modelClass = ChatModelFactory::getClass(ChatModelFactory::CHAT);
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access']  = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create-chat'],
                    'roles' => ['user'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create-message'],
                    'roles' => ['user'],
                ],
                [
                    'allow' => true,
                    'actions' => ['chat-pending'],
                    'roles' => ['user'],
                ],
                [
                    'allow' => true,
                    'actions' => ['chat-history'],
                    'roles' => ['user'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = [
            'chat-history' => [
                'class' => ChatHistoryAction::class,
                'modelClass' => new $this->modelClass(),
            ],
            'chat-pending' => [
                'class' => ChatPendingAction::class,
                'modelClass' => new $this->modelClass(),
            ],
            'create-chat' => [
                'class' => CreateChatAction::class,
                'modelClass' => new $this->modelClass(),
            ],
            'create-message' => [
                'class' => CreateMessageAction::class,
                'modelClass' => new $this->modelClass(),
            ],
        ];

        return Arr::merge(
            Arr::removeSeveral(parent::actions(), ['index', 'view', 'crate', 'update', 'delete']),
            $actions
        );
    }

    protected function verbs()
    {
        return [
            'chat-history' => ['GET'],
            'chat-pending' => ['GET'],
            'create-chat' => ['POST'],
            'create-message' => ['POST'],
        ];
    }
}
