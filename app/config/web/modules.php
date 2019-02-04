<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 17.07.17
 * Time: 17:46
 */
return [
    'finance'      => \App\Modules\Finance\FinanceModule::class,
    'setting'      => \App\Modules\Setting\SettingModule::class,
    'support'      => \App\Modules\Support\SupportModule::class,
    'notification' => \App\Modules\Notification\NotificationModule::class,
    'subscribe'    => \App\Modules\Subscribe\SubscribeModule::class,
    'user'         => \App\Modules\User\UserModule::class,
    'explorer'     => \App\Modules\Explorer\ExplorerModule::class,
    'statistic'    => \App\Modules\Statistic\StatisticModule::class,
    'chat'         => App\Modules\Chat\ChatModule::class,
];
