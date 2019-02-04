<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 14.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use Danhunsaker\BC;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use App\Modules\Explorer\Components\ExplorerModelFactory;

class FinanceAddressBalance extends \App\Modules\Database\FinanceAddressBalance
{
    const COIN_BASE_ADDRESS = 'coinbase';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'lastSync'], 'required'],
            [['balance'], 'number'],
            [['balance'], 'default', 'value' => 0],
            [['address'], 'string', 'min' => 20, 'max' => 35],
            [['lastSync'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['address', 'balance', 'lastSync'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'address',
            'balance',
            'lastSync',
        ];
    }

    public static function find(): ActiveQuery
    {
        return new Query\FinanceUserBalance(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getInputs(): ActiveQuery
    {
        return $this->hasMany(ExplorerModelFactory::getClass(ExplorerModelFactory::INPUT), ['address' => 'address']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOutputs(): ActiveQuery
    {
        return $this->hasMany(ExplorerModelFactory::getClass(ExplorerModelFactory::OUTPUT), ['address' => 'address']);
    }

    /**
     * @param string $address
     * @return float
     */
    public static function getBalance(string $address): float {
        $model = static::find()
            ->with(['inputs', 'outputs'])
            ->where(['address' => $address])
            ->asArray()
            ->one();

        if (!$model) {
            return 0;
        }

        $receive = static::add( ArrayHelper::getColumn($model['outputs'], 'amount'));
        $send = static::add( ArrayHelper::getColumn($model['inputs'], 'amount'));

        $result = $receive - $send;
        return $result;
    }

    /**
     * @param array $io
     * @return float
     */
    private static function add(array $io): float {
        $result = 0;

        foreach ($io as $amount) {
            $result += $amount;
        }

        return $result;
    }
}
