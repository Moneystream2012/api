<?php


namespace App\Modules\Notification\Controllers\Actions\Notification;

use App\Modules\User\Components\UserModelFactory;
use yii\rest\Action;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class SeenStatusAction extends Action
{
    public function run() {
        $post = Yii::$app->request->post();

        if (empty($post['id'])) {
            throw new BadRequestHttpException('Not valid data');
        }

        $model = $this->modelClass::findOne(['_id' => $post['id']]);

        if (empty($model)) {
            throw new NotFoundHttpException('Notification not found.');
        }

        $model->seenBy = array_merge($model->seenBy, [Yii::$app->user->id]);

        return ['result' => $model->save()];
    }
}