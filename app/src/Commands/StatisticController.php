<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 27.11.17 - 11:36
 */


namespace App\Commands;

use App\Modules\Finance\Components\ParkingService;
use yii\console\Controller;

/**
 * This command for monitoring stability system.
 * @package App\Commands
 */
class StatisticController extends Controller
{
    /**
     * For zabbix monitoring. Display diff block count(in minexnode - in database)
     */
    public function actionGetBlockDiffValue() {
        $nodeInfo = \Yii::$app->minexnode->getinfo();
        $dbBlockCount = \Yii::$app->db
            ->createCommand('SELECT MAX(`height`) as blocks FROM {{%explorer_block}}')
            ->queryOne();
        echo $nodeInfo['blocks'] - $dbBlockCount['blocks'];
    }

    /**
     *
     */
    public function actionGetBalanceInNode() {
        $nodeInfo = \Yii::$app->localMinexnode->getinfo();
        echo $nodeInfo['balance'];
    }

    /**
     *
     */
    public function actionGetPayoutPending() {
        $this->disableLogging();
        $parking = new ParkingService();
        echo count($parking->getExpiredParkings());
    }


    /**
     *
     */
    private function disableLogging() {
        foreach (\Yii::$app->getLog()->targets as $target) {
            $target->enabled = false;
        }
    }

}