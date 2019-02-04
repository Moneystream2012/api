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
    PayoutsAction,
    SubscriberCountAction,
    TotalSupplyAction,
    HotReserveAction,
    ParkingUsersAction,
    TotalUsersAction,
    TotalParkingAmountAction,
    ParkingAction,
    DebtsAction,
    DebtsForThisWeekAction
};
use yii\filters\AccessControl;
use yii\rest\OptionsAction;

/**
 * Class ActionController
 * @package App\Modules\Statistic\Controllers
 */
class ActionController extends RestController
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
                        'freezing',
                        'minexbank-reserve',
                        'on-hand',
                        'subscriber-count',
                        'payout',
                        'total-parking-amount',
                        'parking-users',
                        'total-users',
                        'cold-wallet',
                        'total-supply',
                        'total-supply-chart',
                        'hot-reserve',
                        'debts',
                        'parking',
                        'user-parking-chart',
                        'debts-for-this-week'
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
            'freezing' => ['GET', 'OPTIONS'],
            'minexbank-reserve' => ['GET', 'OPTIONS'],
            'on-hand' => ['GET', 'OPTIONS'],
            'subscriber-count' => ['GET', 'OPTIONS'],
            'payout' => ['GET', 'OPTIONS'],
            'total-parking-amount' => ['GET', 'OPTIONS'],
            'user-parking-chart' => ['GET', 'OPTIONS'],
            'parking-users' => ['GET', 'OPTIONS'],
            'total-users' => ['GET', 'OPTIONS'],
            'cold-wallet' => ['GET', 'OPTIONS'],
            'total-supply' => ['GET', 'OPTIONS'],
            'hot-reserve' => ['GET', 'OPTIONS'],
            'debts' => ['GET', 'OPTIONS'],
            'parking' => ['GET', 'OPTIONS'],
            'debts-for-this-week' => ['GET']
        ];
    }

    /**
     * @inheritdoc
     */
	public function actions(): array {
        return [
            'freezing' => [
                'class' => FreezingAction::class,
                'modelClass' => $this->modelClass
            ],
            'minexbank-reserve' => [
                'class' => MinexbankReserveAction::class,
                'modelClass' => $this->modelClass
            ],
            'on-hand' => [
                'class' => OnHandAction::class,
                'modelClass' => $this->modelClass
            ],
            'subscriber-count' => [
                'class' => SubscriberCountAction::class,
                'modelClass' => $this->modelClass
            ],
            'payout' => [
                'class' => PayoutsAction::class,
                'modelClass' => $this->modelClass
            ],
            'total-parking-amount' => [
                'class' => TotalParkingAmountAction::class,
                'modelClass' => $this->modelClass
            ],
            'parking-users' => [
                'class' => ParkingUsersAction::class,
                'modelClass' => $this->modelClass
            ],
            'total-users' => [
                'class' => TotalUsersAction::class,
                'modelClass' => $this->modelClass
            ],
            'cold-wallet' => [
                'class' => ColdWalletAction::class,
                'modelClass' => $this->modelClass
            ],
            'total-supply' => [
                'class' => TotalSupplyAction::class,
                'modelClass' => $this->modelClass
            ],
            'hot-reserve' => [
                'class' => HotReserveAction::class,
                'modelClass' => $this->modelClass
            ],
            'debts' => [
                'class' => DebtsAction::class,
                'modelClass' => $this->modelClass
            ],
            'parking' => [
                'class' => ParkingAction::class,
                'modelClass' => $this->modelClass
            ],
            'debts-for-this-week' => [
	            'class' => DebtsForThisWeekAction::class,
	            'modelClass' => $this->modelClass
            ],
            'options' => [
                'class' => OptionsAction::class
            ]
        ];
	}
}
