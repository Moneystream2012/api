<?php
/**
 * @author Tarasenko Andrii
 * @date: 30.10.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Controllers\Actions\Subscriber;

use yii\rest\Action;
use yii\web\BadRequestHttpException;

/**
 * Class CheckAction
 * @package App\Modules\Subscribe\Controllers\Actions\Subscriber
 */
class CheckAction extends Action
{
    public function run() {
        $post = \Yii::$app->request->post();

        if (empty($post['email'])) {
            throw new BadRequestHttpException();
        }

        $model = $this->modelClass::findOne(['email' => $post['email']]);

        return ['success' => !empty($model)];
    }
}
