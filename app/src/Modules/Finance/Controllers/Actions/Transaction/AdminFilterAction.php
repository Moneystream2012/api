<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 31.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Transaction;

use App\Modules\Finance\Models\FinanceTransaction;
use yii\rest\IndexAction;
use yii\data\{Sort, ActiveDataProvider};

/**
 * Class UserAction
 * @package App\Modules\Finance\Controllers\Actions\Transaction
 */
class AdminFilterAction extends IndexAction
{
    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        $status = \Yii::$app->request->get('status');

        if (!empty($status)) {
            $status = explode(',', $status);
        }
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $sort = new Sort([
            'attributes' => [
                'createdAt' => [
                    'asc' => ['createdAt' => SORT_ASC],
                    'desc' => ['createdAt' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Created',
                ],
                'amount' => [
                    'asc' => ['amount' => SORT_ASC],
                    'desc' => ['amount' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Amount',
                ],
            ]
        ]);

        return \Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $modelClass::find()->whereStatus($status),
            'sort' => $sort,
        ]);
    }

}