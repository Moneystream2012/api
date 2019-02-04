<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 28.11.17
 * Time: 18:00
 */

namespace App\Commands\Transfer\Models;
use App\Commands\Transfer\Exception\TransferException;
use App\Modules\Subscribe\Components\SubscribeModelFactory;
use Yii;
use yii\helpers\Console;

/**
 * Class Subscriber
 * @package App\Commands\Transfer\Models
 */
class Subscriber extends BaseModel
{
    /**
     *
     */
    public function saveSubscriber(): void
    {
        $subscribers = $this->getSubscribers();
        $count = count($subscribers) - 1;

        Console::startProgress(0, $count, __FUNCTION__);
        foreach ($subscribers as $i => $subscriber) {
            $this->saveSubscriberEmail($subscriber);
            Console::updateProgress($i, $count, __FUNCTION__);
        }
        Console::endProgress();
    }

    /**
     * @param array $item
     * @throws TransferException
     */
    public function saveSubscriberEmail(array $item): void
    {
        if (empty($item['email'])) {
            return;
        }

        $subscriberClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER);

        $check = $subscriberClass::find()->where(['email' => $item['email']])->exists();

        if ($check == true) {
            return;
        }

        $subscriberModel = new $subscriberClass;
        $subscriberModel->email = $item['email'];
        $subscriberModel->createdAt = Yii::$app->formatter->asDatetime(time(), \App\Components\BaseModel::DB_DATE_TIME_FORMAT);

        if (!$subscriberModel->save()) {
            Yii::error($subscriberModel->getErrors());
            throw new TransferException('Cant save subscriber');
        }
    }

    /**
     * @return array
     */
    private function getSubscribers(): array
    {
        $data = $this->getFile('subscriber.cvs');

        return $this->transformData($data, [
            'id',
            'email',
            'created'
        ]);
    }
}
