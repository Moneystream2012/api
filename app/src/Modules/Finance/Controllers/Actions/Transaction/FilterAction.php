<?php
/**
 * @author Tarasenko Andrii
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 06.09.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Transaction;

use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceParking;
use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;

/**
 * Class FilterAction
 * @package App\Modules\Finance\Controllers\Actions\Transaction
 */
class FilterAction extends IndexAction
{
    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        $status = \Yii::$app->request->get('status');

        if (!empty($status)) {
            $search = explode(',', $status);
        }

        /* @var FinanceParking $parkingModel */
        $parkingModel = FinanceModelFactory::create(FinanceModelFactory::PARKING);
        $parkingIds = array_map(
            function($e) { return $e['id']; },
            $parkingModel::find()
                ->select('id')
                ->whereStatus([$parkingModel::TYPE_PENDING, $parkingModel::TYPE_COMPLETED])
                ->ownedBy(\Yii::$app->user->id)
                ->asArray()
                ->all()
        );

        return \Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $this->modelClass::find()
                ->whereStatus($search)
                ->andWhere(['parkingId' => $parkingIds])
                ->orderedByCreation(SORT_DESC),
        ]);
    }
}
