<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\User\Components;

use App\Components\Amqp\AmqpRPCServerConsumers;
use App\Modules\Finance\Components\{
    BalanceChange, CompletePayout, FinanceModelFactory
};
use App\Modules\Finance\Models\FinanceAddressBalance;
use App\Modules\Finance\Models\FinanceParking;
use App\Modules\Finance\Models\FinanceParkingType;
use App\Modules\Finance\Models\FinanceTransaction;
use App\Modules\User\Components\UserModelFactory;
use Danhunsaker\BC;
use Yii;
use yii\base\Object;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class UserRPC
 * @package App\Modules\Finance
 */
class UserResponse extends Object
{
	public function getTotalUsers(): int {

		$userModel = UserModelFactory::getClass(UserModelFactory::USER);

		return (int)$userModel::find()->count();
	}
}
