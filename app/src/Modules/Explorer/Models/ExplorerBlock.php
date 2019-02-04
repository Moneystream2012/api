<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 17.08.17
 */

declare(strict_types=1);

namespace App\Modules\Explorer\Models;

use yii\db\ActiveQuery;
use yii\Helpers\ArrayHelper;
use App\Modules\Explorer\Models\{
    BlockStatistics\TotalSupplyStatistic, ExplorerInput, ExplorerOutput
};

class ExplorerBlock extends \App\Modules\Database\ExplorerBlock
{
    public const BLOCK_EMISSION = 2.5;

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        $rules = [
            [['hash'], 'string', 'min' => 64],
            [['hash', 'height', 'totalAmount', 'fee', 'transactions', 'createdAt'], 'safe'],
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() : array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'hash',
            'height',
            'totalAmount',
            'fee',
            'transactions',
            'createdAt',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public static function getHighestBlock(): ActiveQuery
    {
        return self::find()->orderBy(['height' => SORT_DESC]);
    }

    /**
     * @return int
     */
    public static function getMaxHeight(): int
    {
        $highest = self::getHighestBlock()->asArray()->one();

        return !empty($highest['height'])
            ? (int) $highest['height']
            : -1;
    }

    /**
     * Get block by height.
     *
     * @param int $height
     *
     * @return array
     */
    public static function getBlockByHeight(int $height): ?array
    {
        return self::find()->andWhere(['height' => $height])->asArray()->one();
    }

    /**
     * @return ActiveQuery
     */
    public function getInputs(): ActiveQuery
    {
        return $this->hasMany(ExplorerInput::className(), ['transactionId' => 'hash'])
            ->viaTable( ExplorerTransaction::tableName(), ['block' => 'hash']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOutputs(): ActiveQuery
    {
        return $this->hasMany(ExplorerOutput::className(), ['transactionId' => 'hash'])
            ->viaTable( ExplorerTransaction::tableName(),  ['block' => 'hash']);
    }

    /**
     * @return array
     */
    public static function getTotalSupplyData(): array
    {
        $model = new TotalSupplyStatistic();
        return $model->getStatistic();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(ExplorerTransaction::className(), ['block' => 'hash'])->with(['inputs','outputs']);
    }
}
