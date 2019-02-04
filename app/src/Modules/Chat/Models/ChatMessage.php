<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 22.09.17
 * Time: 17:09
 */
declare(strict_types=1);

namespace App\Modules\Chat\Models;


use App\Modules\Chat\Components\ChatModelFactory;
use yii\base\Model;

class ChatMessage extends Model
{
    public $message;
    public $chatId;

    public function rules() : array
    {
        return [
            [['message', 'chatId'], 'required'],
            [['chatId'], 'exist', 'targetClass' => ChatModelFactory::getClass(ChatModelFactory::CHAT), 'targetAttribute' => 'id']
        ];
    }
}
