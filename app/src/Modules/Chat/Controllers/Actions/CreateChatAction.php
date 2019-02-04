<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 18:23
 */
declare(strict_types=1);

namespace App\Modules\Chat\Controllers\Actions;


use App\Modules\Chat\Components\ChatModelFactory;
use App\Modules\Chat\Components\LiveChat\Exceptions\ChatErrorException;
use App\Modules\Chat\Components\LiveChat\Exceptions\ChatNotCreatedException;
use App\Modules\Chat\Models\Chat;
use App\Modules\Chat\Models\ChatHistory;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\rest\Action;

class CreateChatAction extends Action
{
    /**
     * @throws ErrorException
     */
    public function run()
    {
        return \Yii::$app->liveChat->createChat();
    }

}
