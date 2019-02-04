<?php
/**
 * @author Tarasenko Andrii
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 11.09.17
 */

declare(strict_types=1);

namespace App\Modules\User\User;

use Yii;
use yii\data\{Sort, ActiveDataProvider};

/**
 * Class IndexAction
 * @package App\Modules\User\User
 */
class IndexAction extends \yii\rest\IndexAction
{
    /**
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider(): ActiveDataProvider
    {
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
                'balance' => [
                    'asc' => ['balance' => SORT_ASC],
                    'desc' => ['balance' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Created',
                ],
                'parkingBalance' => [
                    'asc' => ['parkingBalance' => SORT_ASC],
                    'desc' => ['parkingBalance' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Created',
                ],
            ]
        ]);

        $query = $modelClass::find()->with(['auth']);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => $sort
        ]);
    }
}
