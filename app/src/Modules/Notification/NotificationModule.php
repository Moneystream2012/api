<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Notification;

use App\Modules\Notification\Workers\NotificationRPC;

/**
 * Class NotificationModule
 * @package App\Modules\Notification
 */
class NotificationModule extends \yii\base\Module
{
    const AMQP_RPC_CLASS = NotificationRPC::class;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'App\Modules\Notification\Controllers';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }
}
