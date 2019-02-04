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
use App\Modules\Finance\Models\FinanceTransaction;
use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;

/**
 * Class LastAction
 * @package App\Modules\Finance\Controllers\Actions\Transaction
 */
class LastAction extends IndexAction
{
    /**
     * @var FinanceTransaction
     */
    public $modelClass;

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {

        return \Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $this->modelClass::find()
                ->whereStatus([$this->modelClass::TYPE_COMPLETED])
                ->orderedByCreation(SORT_DESC),
            'pagination' => [
                'pageSize' => 6
            ]
        ]);
    }
}
