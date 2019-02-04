<?php
/**
 * @author Tarasenko Andrii
 * @date: 29.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers;

use App\Components\RestController;
use App\Helpers\Arr;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Controllers\Actions\UserBalance\FilterAction;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class UserBalanceController
 * @package App\Modules\Finance\Controllers
 */
class UserBalanceController extends RestController
{
    public function init()
    {
        $this->modelClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);
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
					'actions' => ['filter'],
					'roles' => ['user'],
				],
			],
		];

		return $behaviors;
	}

    protected function verbs()
    {
        return [
            'filter' => ['GET'],
        ];
    }


    public function actions(): array
    {
        $actions =  [
            'filter' => [
                'class' => FilterAction::class,
                'modelClass' => $this->modelClass
            ]
        ];

        return Arr::merge(
            Arr::removeSeveral(parent::actions(), ['index', 'view', 'create', 'update', 'delete']),
            $actions
        );


    }
}
