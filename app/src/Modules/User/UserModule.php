<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\User;

use App\Modules\User\Workers\UserRPC;

/**
 * Class UserModule
 * @package App\Modules\User
 */
class UserModule extends \yii\base\Module
{

    const AMQP_RPC_CLASS = UserRPC::class;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = __NAMESPACE__ . '\Controllers';

}
