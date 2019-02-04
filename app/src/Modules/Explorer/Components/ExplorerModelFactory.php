<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 08.08.17
 */

namespace App\Modules\Explorer\Components;

use App\Components\BaseModelFactory;
use App\Modules\Explorer\Models\{
    ExplorerBlock, ExplorerBlockStatistic, ExplorerTransaction, ExplorerInput, ExplorerOutput
};

/**
 * Class ExplorerModelFactory
 * @package App\Modules\Explorer\Components
 */
class ExplorerModelFactory extends BaseModelFactory
{
    public const BLOCK = 'block';
    public const BLOCK_STATISTIC = 'block_statistic';
    public const TRANSACTION = 'transaction';
    public const INPUT = 'input';
    public const OUTPUT = 'output';

    /**
     * Method which populates @var $models
     */
    protected static function populateModels(): void
    {
        static::$models = [
            static::BLOCK => ExplorerBlock::class,
            static::TRANSACTION => ExplorerTransaction::class,
            static::INPUT => ExplorerInput::class,
            static::OUTPUT => ExplorerOutput::class,
        ];
    }
}