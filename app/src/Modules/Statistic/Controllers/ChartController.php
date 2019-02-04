<?php
/**
 * @author Tarasenko Andrii
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers;

use App\Components\RestController;
use App\Modules\Statistic\Controllers\Actions\Action\{
    FreezingAction,
    MinexbankReserveAction,
    ColdWalletAction,
    OnHandAction,
    SubscriberCountAction,
    TotalSupplyAction,
    HotReserveAction,
    ParkingUsersAction,
    TotalParkingAmountAction,
    ParkingAction,
    DebtsAction,
    DebtsForThisWeekAction
};
use App\Modules\Statistic\Controllers\Actions\Chart\{
    DebtsChartAction, ParkingChartAction, PayoutsAction, TotalSupplyChartAction, TotalUsersAction
};
use yii\filters\AccessControl;
use yii\rest\OptionsAction;

/**
 * Class ActionController
 * @package App\Modules\Statistic\Controllers
 */
class ChartController extends RestController
{

	/**
	 * @var string
	 */

    public $modelClass = '';

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
                    'actions' => [
                        'payout',
                        'total-users',
                        'cold-wallet',
                        'parking-chart',
                        'total-supply-chart',
                        'debts-chart'
                    ],
                    'roles' => ['admin'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return [
            'parking-chart' => ['GET', 'OPTIONS'],
            'total-supply-chart' => ['GET', 'OPTIONS'],
            'payout' => ['GET', 'OPTIONS'],
            'total-users' => ['GET', 'OPTIONS'],
            'cold-wallet' => ['GET', 'OPTIONS'],
            'debts-chart' => ['GET', 'OPTIONS'],
        ];
    }

    /**
     * @inheritdoc
     */
	public function actions(): array {
        return [
            'total-users' => [
                'class' => TotalUsersAction::class,
                'modelClass' => $this->modelClass,
            ],
            'options' => [
                'class' => OptionsAction::class
            ],
            'parking-chart' => [
                'class' => ParkingChartAction::class,
                'modelClass' => $this->modelClass
            ],
            'total-supply-chart' => [
                'class' => TotalSupplyChartAction::class,
                'modelClass' => $this->modelClass
            ],

            'cold-wallet' => [
                'class' => Actions\Chart\ColdWalletAction::class,
            ],
            'payout' => [
                'class' => PayoutsAction::class,
                'modelClass' => $this->modelClass
            ],
            'debts-chart' => [
                'class' => DebtsChartAction::class,
                'modelClass' => $this->modelClass
            ],
        ];
	}
}
