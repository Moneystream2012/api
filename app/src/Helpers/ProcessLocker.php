<?php
/**
 * Process lock/unlock routines throw create/remove record in Redis cache.
 *
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date 15.08.17
 */

namespace App\Helpers;

use Yii;

/**
 * Class ProcessLocker
 * @package App\Helpers
 */
class ProcessLocker
{
    const CATEGORY = 'process_locker';

    /**
     * Try to create lock record.
     *
     * @param string $processName
     * @param int $timeout
     *
     * @return boolean
     */
    public static function makeLock($processName = ''): bool
    {
        $process = Yii::$app->id . '_'. $processName;
        $result = false;

        if (empty($processName))
        {
            Yii::error("Lets set process name, exiting", static::CATEGORY);
        }
        elseif (self::checkRunning($process))
        {
            Yii::error("Process $process is already running", static::CATEGORY);
        }
        else
        {
            Yii::$app->redis->set($process, getmypid());
            Yii::info("Process $process starting", static::CATEGORY);

            $result = true;
        }

        return $result;
    }

    /**
     * Check if actual process running.
     *
     * @param string $processName
     *
     * @return bool
     */
    public static function checkRunning($processName = ''): bool
    {
        $processName = Yii::$app->id . '_'. $processName;
        if (Yii::$app->redis->exists($processName))
        {
            if (!posix_getpgid(Yii::$app->redis->get($processName)))
            {
                Yii::info("Process $processName locked but not running. Remove lock! \n", static::CATEGORY);
                self::removeLock($processName);
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Remove lock record while process ends.
     *
     * @param string $processName
     *
     * @return bool
     */
    public static function removeLock($processName = ''): bool
    {

        $processName = Yii::$app->id . '_'. $processName;
        if (Yii::$app->redis->exists($processName))
        {
            Yii::$app->redis->del($processName);
        }

        Yii::info("Process $processName ended\n", static::CATEGORY);

        return !Yii::$app->redis->exists($processName);
    }
}