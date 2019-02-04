<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\User\Workers;

use App\Components\Amqp\AmqpRPCServerConsumers;
use App\Modules\User\Components\UserModelFactory;

/**
 * Class UserRPC
 * @package App\Modules\Finance
 */
class UserRPC extends AmqpRPCServerConsumers
{
	public function getTotalUsers(): int {

		$userModel = UserModelFactory::getClass(UserModelFactory::USER);

		return (int)$userModel::find()->count();
	}
}
