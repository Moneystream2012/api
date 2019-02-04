<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 11:27
 */
declare(strict_types=1);

namespace App\Commands;


use App\Modules\Chat\Models\ChatHistory;
use App\Modules\Explorer\Components\ExplorerModelFactory;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\AddressBalanceLogStatistic\ReserveStatistic;
use App\Modules\Finance\Workers\FinanceRPC;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Workers\NotificationRPC;
use App\Modules\Statistic\Models\OnHands;
use App\Modules\Subscribe\Components\SubscribeModelFactory;
use App\Modules\User\Modules\JWT\JWTCrypror;
use Mailgun\Mailgun;
use yii\console\Controller;

/**
 * {@inheritDoc}
 */
class HelloController extends Controller
{

	public function actionIndex(){
	}

	public function actionIndex1(){

		$response = \Yii::$app->amqpRPCClient->createRequest('App\Modules\Finance\Worker\FinanceRPC', 'fibonachi', [30], true);
		var_dump($response);
	}

	public function actionLoadTest() {
		$time_start = microtime(true);

		$correlationIds = [];
		for($i = 0; $i < 100; $i++) {
			$correlationIds[] = \Yii::$app->amqpRPCClient->createRequest('App\Modules\Finance\Worker\FinanceRPC', 'fibonachi', [30]);
		}
		$res = \Yii::$app->amqpRPCClient->wait($correlationIds, true);

		$time_end = microtime(true);
		$time = $time_end - $time_start;

		var_dump($time);

	}

	public function actionQwe()
    {
//        $api = \Yii::$app->liveChatApi->getClient()->agents->get();

        try {
            $api = \Yii::$app->liveChatApi->getClient()->MyChats->createChat(1238102389123, 'Welcome Message');
            var_dump($api);

        } catch (\Exception $e) {
            echo '123';
        }


    }

}