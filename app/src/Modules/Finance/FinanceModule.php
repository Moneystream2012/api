<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance;

use App\Modules\Finance\Workers\FinanceRPC;
use Yii;

/**
 * Class FinanceModule
 * @package App\Modules\Finance
 */
class FinanceModule extends \yii\base\Module
{

	const AMQP_RPC_CLASS = FinanceRPC::class;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = __NAMESPACE__ . '\Controllers';

    /**
     * @inheritdoc
     */
	public function init(): void {
		if (Yii::$app instanceof yii\console\Application) {
			$this->controllerNamespace = __NAMESPACE__ . '\Commands';
		}

		parent::init();

		// custom initialization code goes here
	}
}
