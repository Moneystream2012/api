<?php
/**
 * @author Tarasenko Andrii
 * @date: 29.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\UserBalance;

use App\Components\Math;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceParking;
use Yii;
use yii\rest\Action;
use yii\web\NotFoundHttpException;

/**
 * Class FilterAction
 * @package App\Modules\Finance\Controllers\Actions\UserBalance
 */
class FilterAction extends Action
{
    public function run() {

        $balance = $this->getUserBalance();
        $parkedBalance = $this->getParkedUserBalance();

        return [
            'balance' => Math::Add($balance, 0, Yii::$app->params['scale']),
            'parkingBalance' => Math::Add($parkedBalance, 0, Yii::$app->params['scale']),
            'balanceDifference' => Math::Sub($balance, $parkedBalance, Yii::$app->params['scale'])
        ];

    }

    private function getUserBalance(): float
    {
        $model = $this->modelClass::find()->where(['address' => Yii::$app->user->address])->one();

        if ($model == null) {
            return 0.0;
        }

        return (float)$model->balance;
    }

    private function getParkedUserBalance(): float
    {
        $total = 0;

        $modelClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        /* @var FinanceParking $this->modelClass */
        $items = $modelClass::find()
            ->select(['amount'])
            ->whereStatus([FinanceParking::TYPE_ACTIVE, FinanceParking::TYPE_PENDING])
            ->ownedBy(Yii::$app->user->id)
            ->asArray()->all();

        foreach ($items as $item) {
            // @FiXME call ones in the end
            $total = Math::Add($total, $item['amount'], Yii::$app->params['scale']);
        }

        return (float)$total;
    }
}
