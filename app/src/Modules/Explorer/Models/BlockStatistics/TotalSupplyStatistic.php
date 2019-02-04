<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.11.17
 * Time: 17:34
 */

namespace App\Modules\Explorer\Models\BlockStatistics;


use App\Modules\Explorer\Models\ExplorerBlock;
use yii\db\Expression;

class TotalSupplyStatistic extends ExplorerBlock
{
    public $blockCount;

    const BLOCK_REWARD = 2.5;
    const MNX_PRE_MINE = 5500000;

    /**
     * @return array
     */
    public function getStatistic(): array
    {
        $result = [];

        $models = self::find()->select(['count(createdAt) as blockCount', 'createdAt'])
            ->groupBy(new Expression('YEAR(createdAt), MONTH(createdAt), DAY(createdAt)'))->all();

        foreach ($models as $model) {
            $result[] = [
                'name' => $model->getCreatedAt(),
                'value' => static::MNX_PRE_MINE + $model->blockCount * self::BLOCK_REWARD,
            ];
        }

        return $result;
    }

    public function getCreatedAt()
    {
        return date('Y-m-d',strtotime($this->createdAt));
    }
}
