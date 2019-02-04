<?php

declare(strict_types=1);

/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 *
 * @date 08.08.17
 */

namespace App\Modules\Explorer\Commands\Actions\Explorer;

use App\Helpers\Arr;
use Yii;
use yii\base\Action;
use App\Helpers\ProcessLocker;
use App\Modules\Explorer\{
    Components\Synchronizer
};

/**
 * Class SyncAction
 * @package App\Modules\Explorer\Controllers\Actions\Block
 */

class SyncAction extends Action
{
    private const LOG_CATEGORY = 'synchronizeAction';

    /**
     * @var Synchronizer $sync
     */
    private $sync;

    /**
     * @param string $hash
     * @throws \Exception
     */
    public function run(string $hash): void {
        $this->lockProcess();

	    try {
            self::info('Init');
            $this->sync = new Synchronizer();

            $nodeBlock = $this->sync->getNodeBlockByHash($hash);

            if (empty($nodeBlock)) {
                throw new \Exception('Not found block in node. Abort synchronization.');
            }

            if (!$this->sync->isBestBlock($nodeBlock)) {
                static::info('We have already best block, cooler then we receive.');
                $this->unlockProcess();
                return;
            }

            $rootBlock = $this->sync->findRootInDb();

            if (empty($rootBlock)) {
                static::error('Can\'t find root block, exiting!');
                $this->unlockProcess();
                return;
            }

            $blockHeight = (int) $rootBlock['height'];
            $nodeBlockHeight = (int) $nodeBlock['height'];

            $id = (int) $rootBlock['id'];

            $this->sync->deleteBlocksInDbIfNeed($blockHeight, $id);

            $this->sync->createBlockChain( $blockHeight + 1, $nodeBlockHeight);

        } catch (\Exception $e) {
            $this->unlockProcess();
	        throw $e;
        }
        $this->unlockProcess();
    }

    private function lockProcess(): void {
        if(ProcessLocker::checkRunning($this->id)) {
            Yii::$app->end('Process already running . Exit' . "\n");
        }
	    if (!ProcessLocker::makeLock($this->id)) {
            Yii::$app->end('Couldn\'t lock the process. End' . "\n");
	    }

        self::info('Lock process.');
    }

    /**
     *
     */
    private function unlockProcess(): void {
        self::info('Unlock process.');
        ProcessLocker::removeLock($this->id);
    }

    /**
     * @param string $message
     */
    private static function info(string $message): void {
        Yii::info($message, self::LOG_CATEGORY);
    }

    /**
     * @param string $message
     */
    private static function error(string $message): void {
        Yii::error($message, self::LOG_CATEGORY);
    }
}
