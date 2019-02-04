<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 23.11.17
 * Time: 16:41
 */

namespace App\Modules\Notification\Controllers\Actions\Notification;


use App\Modules\Notification\Models\Notification;
use App\Modules\Subscribe\Components\SubscribeModelFactory;
use App\Modules\Subscribe\Models\Subscriber;
use yii\helpers\Url;
use yii\rest\CreateAction;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Class CreateNotificationAction
 * @package App\Modules\Notification\Controllers\Actions\Notification
 */
class CreateNotificationAction extends CreateAction
{
    private const SCENARIO_PARKING_TYPE = 'parkingType';

    public function run()
    {
        $data = Yii::$app->request->post();
        $scenario = '';

        if (!empty($data['scenario'])) {
            $scenario = $data['scenario'];
        }

        /* @var $model Notification */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load($data, '');
        if ($model->save()) {

            $this->notificate($model, $scenario);

            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));

        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

    private function notificate(Notification $model, $scenario = '') : void
    {
        $userClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER);
        $usersModels = $userClass::find()->all();

        foreach ($usersModels as $userModel) {
            $this->sendMail($userModel->email, $model, $scenario);
        }
    }

    private function sendMail(string $email, Notification $model, $scenario = '')
    {
        $template = 'notification.php';

        if (!empty($scenario) && $scenario === self::SCENARIO_PARKING_TYPE) {
            $template = 'parkingType.php';
        }

        Yii::$app->mailgun->send(Yii::$app->params['mail']['notification']['domain'], [
            'from'    => 'MinexBank Assistant <' . Yii::$app->params['mail']['notification']['from'] . '>',
            'to'      => $email,
            'subject' => $model->title,
            'html'    => \Yii::$app->view->renderFile('@app/Modules/Notification/Views/Mail/'.$template, [
                'message' => $model->content
            ])
        ]);
    }
}
