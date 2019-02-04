<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @author Tarasenko Andrii
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Components;

use App\Components\Amqp\AmqpRPCServerConsumers;
use App\Components\GlobalConstants;
use App\Components\Math;
use App\Modules\Finance\Components\{
    BalanceChange, CompletePayout, FinanceModelFactory
};
use App\Modules\Finance\Workers\Statistic;
use Danhunsaker\BC;
use Yii;
use yii\base\Object;
use yii\helpers\{ArrayHelper, Json};
use App\Modules\Explorer\{
    Components\ExplorerModelFactory, Models\ExplorerBlock
};
use App\Modules\Finance\Models\{
    FinanceAddressBalance,
    FinanceParking,
    FinanceParkingType,
    FinanceTransaction
};

/**
 * Class FinanceModule
 * @package App\Modules\Finance
 */
class FinanceResponse extends Object implements GlobalConstants
{
    const
        MNX_PRE_MINE = 5500000,
        MNX_TOTAL_SUPPLY = 19000000,
        MNX_FREEZING = 1000000,
        MNX_BLOCK_REWARD = 2.5;

    /**
     * @param array $changes
     *
     * @return bool
     */
	public function changeBalance(array $changes): bool {
		return (new BalanceChange())->proceed($changes) > 0;
	}

    /**
     * @param string $address
     */
    public function createAddressBalance(string $address): void {

        /* @var FinanceAddressBalance $modelClass */
	    $modelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);

	    $model = $modelClass::find()->where(['address' => $address])->select(['id'])->asArray()->one();

	    if ($model === null) {
	        Yii::warning('Couldn\'t find user balance id DB', 'finance');

	        /* @var FinanceAddressBalance $model */
		    $model = new $modelClass([
			    'address'  => $address,
			    'balance'  => 0,
			    'lastSync' => Yii::$app->formatter->asDatetime(time(), $modelClass::DB_DATE_TIME_FORMAT)
		    ]);


            if (!$model->save()) {
                Yii::error('Couldn\'t create user balance. Address: ' . Json::encode($model->attributes) );
            }
	    }
    }

    public function addressBalance(string $address): float {
        $model = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE)::find()
            ->select(['balance'])
            ->where(['address' => $address])
            ->asArray()
            ->one();

        return !empty($model) ? (float)$model['balance'] : 0;
    }

    public function addressParkingBalance(int $userId): float {
        $total = 0;

        $items = FinanceModelFactory::getClass(FinanceModelFactory::PARKING)::find()
            ->select(['amount'])
            ->whereStatus([FinanceParking::TYPE_ACTIVE, FinanceParking::TYPE_PENDING])
            ->ownedBy($userId)
            ->asArray()->all();

        foreach ($items as $item) {
            // @FiXME call ones in the end
            $total = BC::add($total, $item['amount'], Yii::$app->params['scale']);
        }

        return (float) $total;
    }

    public function getTotalPayoutsForGraph(): array {
        $result = [];

        /* @var FinanceParkingType $parkingTypeModel */
        $parkingTypeModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);

        /* @var FinanceParking $parkingModel */
        $parkingModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        /* @var FinanceTransaction $transactionModel */
        $transactionModel = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        $parkingTypes = $parkingTypeModel::find()->select(['id', 'name'])->asArray()->all();
        $parkings = $parkingModel::find()->select(['id'])->whereStatus($parkingModel::TYPE_COMPLETED)->asArray()->all();
        $parkingIds = array_map(function ($parking) { return $parking['id']; }, $parkings);

        $transactions = $transactionModel::find()
            ->select(['amount', 'createdAt', 'parkingId'])
            ->whereStatus($transactionModel::TYPE_COMPLETED)
            ->where(['parkingId' => $parkingIds])
            ->with(['parking'])
            ->asArray()
            ->all();

        $totalSeries = [];
        foreach ($parkingTypes as $type) {
            $seriesForType = [];
            $typeId = $type['id'];

            if (empty($result[$typeId])) {
                $result[$typeId] = [
                    'name' => $type['name'],
                    'series' => []
                ];
            }

            foreach ($transactions as $index => $transaction) {
                $date = Yii::$app->formatter->asDate($transaction['createdAt']);

                if (empty($totalSeries[$date])) {
                    $totalSeries[$date] = ['name' => $date, 'value' => 0];
                }

                if ($transaction['parking']['typeId'] == $typeId) {
                    if (empty($seriesForType[$date])) {
                        $seriesForType[$date] = ['name' => $date, 'value' => 0];
                    }

                    $seriesForType[$date]['value'] = (float)Math::add($seriesForType[$date]['value'], $transaction['amount'], Yii::$app->params['scale']);

                    $totalSeries[$date]['value'] = (float)Math::Add($totalSeries[$date]['value'], $transaction['amount'], Yii::$app->params['scale']);

                    unset($transactions[$index]);
                }
            }

            $result[$typeId]['series'] = array_values($seriesForType);
        }

        $result['total'] = [
            'name' => 'Total payouts',
            'series' => array_values($totalSeries)
        ];

        return $result;
    }

    public function getTotalPayouts(): array {
        $result = [];

        /* @var FinanceParkingType $parkingTypeModel */
        $parkingTypeModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);

        /* @var FinanceParking $parkingModel */
        $parkingModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        /* @var FinanceTransaction $transactionModel */
        $transactionModel = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);

        $parkingTypes = $parkingTypeModel::find()->select(['id', 'name'])->asArray()->all();
        $parkings = $parkingModel::find()->select(['id'])->whereStatus($parkingModel::TYPE_COMPLETED)->asArray()->all();
        $parkingIds = array_map(function ($parking) { return (int)$parking['id']; }, $parkings);

        $transactions = $transactionModel::find()
            ->select(['amount', 'parkingId'])
            ->andWhere(['parkingId' => $parkingIds])
            ->whereStatus($transactionModel::TYPE_COMPLETED)
            ->with(['parking'])
            ->asArray()
            ->all();

        $total = '0';

        foreach ($parkingTypes as $type) {

            if (empty($result[$type['id']])) {
                $result[$type['id']] = '0';
            }

            foreach ($transactions as $index => $transaction) {
                if ($transaction['parking']['typeId'] == $type['id']) {
                    $result[$type['id']] = Math::add($result[$type['id']], $transaction['amount'], Yii::$app->params['scale']);
                    unset($transactions[$index]);
                }
            }

            $total = Math::add($total, $result[$type['id']], Yii::$app->params['scale']);
        }

        $result['total'] = $total;

        return $result;
    }

    public function getTotalSupplyStatistic(): array {

        $inUse = $this->getTotalSupply();

        return [
            'inUse' => $inUse,
            'totalSupply' => $totalSupply = static::MNX_TOTAL_SUPPLY,
            'percentage' => 100 * $inUse / $totalSupply,
        ];
    }

    public function getTotalSupply(): float {
        /** @var $blockModel ExplorerBlock */
        $blockModel = ExplorerModelFactory::create(ExplorerModelFactory::BLOCK);
        $height = $blockModel::getMaxHeight() == -1
            ? 0
            : $blockModel::getMaxHeight() - 1;


        return static::MNX_PRE_MINE + $height * static::MNX_BLOCK_REWARD;
    }

    public function getMinexbankReserve(): float {

        $payoutSource = FinanceModelFactory::getClass(FinanceModelFactory::PAYOUT_SOURCE);
        $sources = $payoutSource::find()
            ->select(['address'])
            ->asArray()
            ->all();

        $addresses = array_merge(
            ArrayHelper::getColumn($sources, 'address'),
            static::HOT_WALLET_ADDRESSES
        );


        $reserve = 0;
        /* @var FinanceAddressBalance $addressBalance */
        $addressBalance = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);
        foreach ($addresses as $address) {
            $reserve += $addressBalance::getBalance($address);
        }

        return (float) number_format($reserve, Yii::$app->params['scale'], '.', '');
    }

    /**
     * Get total balance of all payout sources.
     * @return string
     */
    public function getHotReserve(): string
    {
        $totalBalance = 0;

        $sourceModelClass = FinanceModelFactory::getClass(FinanceModelFactory::PAYOUT_SOURCE);
        $balanceModelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);

        $sourceAddresses = $sourceModelClass::find()
            ->select('address')
            ->all();

        if (!empty($sourceAddresses)) {
            $addresses = array_map(
                function($e) { return $e->address; },
                $sourceAddresses
            );

            $balances = $balanceModelClass::find()
                ->select('balance')
                ->where(['address' => $addresses])
                ->asArray()
                ->all();

            foreach ($balances as $balance) {
                $totalBalance = Math::Add($totalBalance, $balance['balance'], Yii::$app->params['scale']);
            }
        }


        return $totalBalance;
    }

    public function getCountParkingUsers(): int {
        /* @var FinanceParking $parkingModel */
        $parkingModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);
        $parkings = $parkingModel::find()->whereStatus([$parkingModel::TYPE_ACTIVE, $parkingModel::TYPE_PENDING])
            ->select(['id'])
            ->groupBy('userId')
            ->asArray()
            ->all();

        return count($parkings);
    }

    public function getOnHandAmount(): float {

        /** @var $blockModel ExplorerBlock */
        $blockModel = ExplorerModelFactory::create(ExplorerModelFactory::BLOCK);

        $height = $blockModel::getMaxHeight() == -1
            ? 0
            : $blockModel::getMaxHeight() - 1;

        $supply = $this->getTotalSupply();
        $reserve = $this->getMinexbankReserve();
        $freezing = static::MNX_FREEZING;

        $result =  $supply - $reserve - $freezing;

        return (float) number_format($result, Yii::$app->params['scale'], '.', '');

//	    return BC::parse('{preMine} + {rewards} - {reserve} - {freezing}', [
//		    'preMine'  => static::MNX_PRE_MINE,
//		    'rewards'  => ($blockModel::getMaxHeight() - 1) * static::MNX_BLOCK_REWARD,
//		    'reserve'  => $this->getMinexbankReserve(),
//		    'freezing' => static::MNX_FREEZING,
//	    ], Yii::$app->params['scale']);
    }

    public function getFreezingAmount(): int {

        return static::MNX_FREEZING;
    }

    public function getTotalParkingAmount(): array {

	    /** @var FinanceParking $parkingModelClass */
	    $parkingModelClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        $amounts = $parkingModelClass::find()
            ->select(['typeId', 'count(*) as cnt'])
            ->where(['status' => [$parkingModelClass::TYPE_ACTIVE, $parkingModelClass::TYPE_PENDING]])
            ->groupBy('typeId')
            ->asArray()
            ->all();

        $parkings = $parkingModelClass::find()
            ->where(['status' => [$parkingModelClass::TYPE_ACTIVE, $parkingModelClass::TYPE_PENDING]])
            ->asArray()
            ->all();

        $amounts = ArrayHelper::map($amounts, 'typeId', 'cnt');

        $formatted = [];
        foreach ($amounts as $id => $count) {
            $formatted[(string)$id] = (int)$count;
        }

        $formatted['total'] = array_sum($amounts);

        return $formatted;
    }

    public function getTotalParkings(): array {

        $parkingTypeModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);

        /* @var FinanceParking $parkingModel */
        $parkingModel = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        $parkingTypes = $parkingTypeModel::find()->select(['id'])->asArray()->all();
        $parkings = $parkingModel::find()
            ->select(['amount', 'typeId'])
            ->whereStatus([$parkingModel::TYPE_ACTIVE, $parkingModel::TYPE_PENDING])
            ->asArray()
            ->all();

        $result = [];

        $total = Math::Add(0, 0, Yii::$app->params['scale']);
        foreach ($parkingTypes as $type) {
            if (empty($result[$type['id']])) {
                $result[$type['id']] = Math::Add(0, 0, Yii::$app->params['scale']);
            }

            foreach ($parkings as $index => $parking) {

                if ($parking['typeId'] == $type['id']) {
                    $result[$type['id']] = Math::Add($result[$type['id']], $parking['amount'], Yii::$app->params['scale']);
                    unset($parkings[$index]);
                }
            }

            $total = Math::Add($total, $result[$type['id']], Yii::$app->params['scale']);
        }

        $result['total'] = $total;

        return $result;

    }

    /**
     * Get debts.
     * @return array
     */
    public function getDebts(): array {
        $parkingTypeModelClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);
        /* @var FinanceParking $parkingModelClass */
        $parkingModelClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);

        $types = ArrayHelper::getColumn($parkingTypeModelClass::find()
            ->select(['id'])
            ->all(),
            'id'
        );

        $result = [];

        $parkings = $parkingModelClass::find()
            ->select(['typeId', 'amount', 'rate'])
            ->where(['status'=>[$parkingModelClass::TYPE_ACTIVE, $parkingModelClass::TYPE_PENDING]])
            ->asArray()
            ->all();

        foreach ($types as $typeId) {
            if (!isset($result[$typeId])) {
                $result[$typeId] = Math::Add(0, 0, Yii::$app->params['scale']);
            }
        }

        $total = Math::Add(0, 0, Yii::$app->params['scale']);
        foreach ($parkings as $key => $parking)
        {
            if (!isset($result[$parking['typeId']]))
            {
                $result[$parking['typeId']] = Math::Add(0, 0, Yii::$app->params['scale']);
            }

            $amount = $parking['amount'] * $parking['rate']/100;

            $result[$parking['typeId']] = Math::Add($result[$parking['typeId']], $amount, Yii::$app->params['scale']);
            $total = Math::Add($total, $amount, Yii::$app->params['scale']);

            unset($parkings[$key]);
        }

        $result['total'] = $total;

        return $result;
    }

	/**
	 *
	 */
    public function getDebtsForThisWeek(): array {
	    return (new Statistic())->debtsForThisWeek();
    }

}
