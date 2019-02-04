<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 18:16
 */
declare(strict_types=1);

namespace App\Modules\Chat\Components;


use App\Components\BaseModelFactory;
use App\Modules\Chat\Models\Chat;
use App\Modules\Chat\Models\ChatHistory;

class ChatModelFactory extends BaseModelFactory
{
    public const CHAT = 'CHAT';
    public const CHAT_HISTORY = 'CHAT_HISTORY';

    /**
     * Method which populates @var $models
     */
    protected static function populateModels(): void
    {
        static::$models = [
            static::CHAT => Chat::class,
            static::CHAT_HISTORY => ChatHistory::class,
        ];
    }
}
