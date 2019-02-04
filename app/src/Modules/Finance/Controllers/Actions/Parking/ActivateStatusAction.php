<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 11.09.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use App\Components\Math;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceParking;
use function PHPSTORM_META\type;
use yii\rest\Action;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Class ActivateStatusAction
 * @package App\Modules\Finance\Controllers\Actions\Parking
 */
class ActivateStatusAction extends Action
{

    /* @var FinanceParking $modelClass */
    public $modelClass;

	/**
	 * @throws BadRequestHttpException
	 * @throws HttpException
	 * @throws NotFoundHttpException
	 */
    public function run() {
        $status = false;

        $post = \Yii::$app->request->post();

        if (empty($post['id'])) {
            throw new BadRequestHttpException('Id of parking not set.');
        }

        /* @var FinanceParking $model */
        $model = $this->modelClass::find()->where([
            'id' => $post['id'],
            'status' => $this->modelClass::TYPE_CANCELED
        ])->with(['type'])->one();

        if (empty($model)) {
            throw new NotFoundHttpException('Parking not found');
        }

        $model->status = $this->modelClass::TYPE_ACTIVE;
        $model->createdAt = \Yii::$app->formatter->asDatetime(time(), $this->modelClass::DB_DATE_TIME_FORMAT);
        $model->rate = $model->type->rate;
        $amount = $model->amount * $model->type->rate / 100;

        $model->returnedAmount = Math::Add($amount, 0, 8);

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if (!$model->save()) {
                \Yii::error($model->getErrors(), __CLASS__);
                throw new ServerErrorHttpException('Status not updated');
            }

            $logModel = FinanceModelFactory::create(FinanceModelFactory::PARKING_LOG, [
                'parkingId' => $model->id,
                'status' => $model->status
            ]);

            if (!$logModel->save()) {
                \Yii::warning($logModel->getErrors(), __CLASS__);
                throw new ServerErrorHttpException('Parking log not saved for parking id: ' . $model->id);
            }

            $status = true;
            $transaction->commit();
        } catch (\Exception $e) {
            \Yii::error('Transaction rollback:' . $e->getMessage(), __CLASS__);
            $transaction->rollBack();
        }


        return [
            'success' => $status
        ];
    }
}