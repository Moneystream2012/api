<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 13.09.17
 * Time: 16:48
 */

namespace App\Modules\Notification\Workers;


use App\Components\Amqp\AmqpRPCServerConsumers;
use App\Modules\Subscribe\Components\SubscribeModelFactory;

class NotificationRPC extends AmqpRPCServerConsumers
{
    /**
     * @param array $parkings
     */
    public function sendEmails(array $parkings): void
    {
        $subscribers = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER);

        $models = $subscribers::find()->all();

        foreach ($models as $model) {
            \Yii::$app->mailer->setViewPath('@App/Modules/Notification/Views');

            \Yii::$app->mailer->compose('Mail/notification', [
                'user' => $model,
                'parkings' => ['asd' => 'qwe']
            ])
                ->setFrom(\Yii::$app->params['mail']['notification']['from'])
                ->setTo($model->email)
                ->setSubject(\Yii::$app->params['mail']['notification']['subject'])
                ->send();
        }
    }
}
