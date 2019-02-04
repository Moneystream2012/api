<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\User\Components\UserResponse;
use yii\rest\Action;

/**
 * Class TotalUsersAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class TotalUsersAction extends Action
{
    public function run() {

        $user = new UserResponse();
        $total = $user->getTotalUsers();

//        $total =  \Yii::$app->amqpRPCClient->createRequest(
//            'App\Modules\User\Workers\UserRPC',
//            'getTotalUsers',
//            [],
//            true
//        );

        return ['total' => $total];
    }
}