<?php
/**
 * @author Tarasenko Andrii
 * @date: 11.10.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Controllers\Actions\Subscriber;

use yii\rest\Action;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class DeleteAction
 * @package App\Modules\Subscribe\Controllers\Actions\Subscriber
 */
class DeleteAction extends Action
{
    public function run() {
        $post = \Yii::$app->request->post();

        if (empty($post['email'])) {
            throw new BadRequestHttpException('Not valid data');
        }

        $model = $this->modelClass::findOne(['email' => $post['email']]);

        if (empty($model)) {
            throw new NotFoundHttpException('Subscriber not found');
        }

        return ['success' => (bool)$model->delete()];
    }
}
