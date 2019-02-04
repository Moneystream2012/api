<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 27.09.17
 * Time: 17:22
 */
declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Action;

use App\Modules\Finance\Components\FinanceResponse;
use yii\rest\Action;

/**
 * Class DebtsForThisWeekAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class DebtsForThisWeekAction extends Action
{

	public function run(): array {
	    $finance = new FinanceResponse();

	    return $finance->getDebtsForThisWeek();

//		return \Yii::$app->amqpRPCClient->createRequest(
//			'App\Modules\Finance\Workers\FinanceRPC',
//			'getDebtsForThisWeek',
//			[],
//			true
//		);
	}
}