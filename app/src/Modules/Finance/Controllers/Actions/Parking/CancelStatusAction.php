<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 11.09.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceParking;
use yii\rest\Action;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Class CancelStatusAction
 * @package App\Modules\Finance\Controllers\Actions\Parking
 */
class CancelStatusAction extends Action
{
    /* @var FinanceParking $modelClass */
    public $modelClass;

    public function run() {
        $post = \Yii::$app->request->post();

        if (empty($post['id'])) {
            throw new BadRequestHttpException('Id of parking not set.');
        }

        $model = $this->modelClass::findOne($post['id']);

        if (empty($model)) {
            throw new NotFoundHttpException('Parking not found');
        }

        if ($model->status === $this->modelClass::TYPE_CANCELED || $model->status === $this->modelClass::TYPE_COMPLETED || $model->isExpired()) {
            throw new BadRequestHttpException('Couldn\'t cancel parking.');
        }

        $model->status = $this->modelClass::TYPE_CANCELED;

        $transaction = \Yii::$app->db->beginTransaction();

        $result = ['success' => true];

        try{
            if (!$model->save()) {
                $transaction->rollBack();

                if (!$model->hasErrors()) {
                    throw new ServerErrorHttpException('Unknown error.');
                }

                $result = $model;

            } else {
                $logModel = FinanceModelFactory::create(FinanceModelFactory::PARKING_LOG, [
                    'parkingId' => $model->id,
                    'status' => $model->status
                ]);

                if (!$logModel->save()) {
                    \Yii::warning('Parking log not saved for parking id: ' . $model->id, 'finance');
                }

            }

            $transaction->commit();

        } catch(\Throwable $exception) {

            \Yii::error($exception->getMessage());
            $transaction->rollBack();
            $result = ['success' => false];
        }

        return $result;
    }
}