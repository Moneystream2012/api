<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe;

use App\Modules\Subscribe\Workers\SubscribeRPC;

/**
 * Class SubscribeModule
 * @package App\Modules\Subscribe
 */
class SubscribeModule extends \yii\base\Module
{
    const AMQP_RPC_CLASS = SubscribeRPC::class;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'App\Modules\Subscribe\Controllers';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }
}
