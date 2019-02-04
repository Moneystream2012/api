<?php
/**
 * @author Tarasenko Andrii
 * @date: 23.10.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use Yii;

/**
 * Class CreateAction
 * @package App\Modules\Finance\Controllers\Actions\Parking
 */
class CreateAction extends \yii\rest\CreateAction
{
    public function run() {
        $post = \Yii::$app->request->post();

        $model = new $this->modelClass();

        $model->load($post, '');

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            return $model;
        }

        return $model;
    }
}
