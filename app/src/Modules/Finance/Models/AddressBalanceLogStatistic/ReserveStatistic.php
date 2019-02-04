<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.11.17
 * Time: 17:56
 */

namespace App\Modules\Finance\Models\AddressBalanceLogStatistic;


use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceAddressBalanceLog;
use yii\db\Expression;

class ReserveStatistic extends FinanceAddressBalanceLog
{
    public $dayBalance;

    const MINEX_RESERVE = 'XVFYK9MgdMDhYwwnTsEkqBFvUytC5QtWE4';

    /**
     * @return array|null
     */
    public function getStatistic(): ?array
    {
        $result = [];

        $addressBalanceClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);

        $addressBalanceModel = $addressBalanceClass::find()->where([
            'address' => self::MINEX_RESERVE
        ])->one();

        if ($addressBalanceModel == null) {
            return null;
        }

        $models = self::find()->select(['max(balance) as dayBalance', 'createdAt'])
            ->where([
                'between',
                'createdAt',
                new Expression('DATE_SUB(NOW(), INTERVAL 7 DAY)'),
                new Expression('NOW()')
            ])
            ->andWhere([
                'addressBalanceId' => $addressBalanceModel->id
            ])
            ->groupBy(new Expression('YEAR(createdAt), MONTH(createdAt), DAY(createdAt)'))
            ->all();

        foreach ($models as $model) {
            $result[] = [
                'name' => $model->getCreatedAt(),
                'value' => $model->dayBalance,
            ];
        }

        return $result;
    }

    public function getCreatedAt()
    {
        return date('Y-m-d',strtotime($this->createdAt));
    }
}
