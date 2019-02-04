<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers;

use App\{
    Components\RestController,
    Modules\Finance\Components\FinanceModelFactory
};
use yii\filters\AccessControl;

/**
 * Class PayoutSourceController
 * @package App\Modules\Finance\Controllers
 */
class PayoutSourceController extends RestController
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->modelClass = FinanceModelFactory::getClass(FinanceModelFactory::PAYOUT_SOURCE);
    }

	/**
	 * Behaviors
	 *
	 * @return array
	 */
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();

		$behaviors['access']  = [
			'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
				[
					'allow' => true,
					'actions' => ['index', 'view', 'create', 'update', 'delete'],
					'roles' => ['admin'],
				],
			],
		];

		return $behaviors;
	}
    /** @FIXME ApiDoc */

    protected function verbs()
    {
        return parent::verbs();
    }

}
