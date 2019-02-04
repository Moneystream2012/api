<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers;

use App\Components\RestController;
use App\Modules\Finance\{
    Components\FinanceModelFactory, Models\CreateParkingModel, Models\FinanceParking\CreateParking
};
use App\Helpers\Arr;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\IndexAction;

/**
 * Class ParkingController
 * @package App\Modules\Finance\Controllers
 */
class ParkingController extends RestController
{
    /**
     * @inheritdoc
     */
	public function init(): void {
        $this->modelClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING);
	}

    /**
     * Behaviors
     *
     * @return array
     */
	public function behaviors(): array {
        $behaviors = parent::behaviors();

        $behaviors['access']  = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'admin-status', 'admin-count', 'statistic'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create', 'status', 'count', 'cancel', 'activate'],
                    'roles' => ['user'],
                ],
            ],
        ];

        return $behaviors;
	}

	protected function verbs(): array {
        return [
            'create' => ['POST'],
            'admin-status' => ['GET', 'OPTIONS'],
            'admin-count' => ['GET'],
            'status' => ['GET', 'OPTIONS'],
            'count' => ['GET'],
            'cancel' => ['POST'],
            'activate' => ['POST'],
            'index' => ['GET'],
            'statistic' => ['GET'],
        ];
	}

    /**
     * @inheritdoc
     */
	public function actions(): array {
        $actions = [
            'status' => [
                'class' => Actions\Parking\StatusAction::class,
                'modelClass' => $this->modelClass
            ],
            'admin-status' => [
                'class' => Actions\Parking\AdminStatusAction::class,
                'modelClass' => $this->modelClass
            ],
            'count' => [
                'class' => Actions\Parking\CountAction::class,
                'modelClass' => $this->modelClass
            ],
            'admin-count' => [
                'class' => Actions\Parking\AdminCountAction::class,
                'modelClass' => $this->modelClass
            ],
            'cancel' => [
                'class' => Actions\Parking\CancelStatusAction::class,
                'modelClass' => $this->modelClass
            ],
            'activate' => [
                'class' => Actions\Parking\ActivateStatusAction::class,
                'modelClass' => CreateParking::class
            ],
            'create' => [
                'class' => Actions\Parking\CreateAction::class,
                'modelClass' => CreateParking::class
            ],
            'statistic' => [
                'class' => Actions\Parking\StatisticAction::class,
                'modelClass' => $this->modelClass
            ],
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function($action) {
                    /* @var $modelClass \yii\db\BaseActiveRecord */
                    $modelClass = $action->modelClass;

                    return Yii::createObject([
                        'class' => ActiveDataProvider::className(),
                        'query' => $modelClass::find(),
                        'pagination' => [
                            'pageSize' => 15
                        ]
                    ]);
                }
            ]
        ];

        return Arr::merge(
            Arr::removeSeveral(parent::actions(), ['view', 'update', 'delete']),
            $actions
        );
	}

    /**
     * @api {post} parking Create parking
     * @apiVersion 1.0.0
     * @apiName CreateParking
     * @apiGroup Parking
     *
     * @apiDescription Create new parking object.
     *
     * @apiParam {Integer} userId Parking's user id.
     * @apiParam {Integer} typeId Parking's type id.
     * @apiParam {Integer} amount Parking's amount.
     * @apiParam {Number} rate Parking's rate.
     * @apiParam {String=pending,active,canceled,completed} status Parking's status.
     *
     * @apiSuccess {Integer} id Parking's id.
     * @apiSuccess {Integer} userId Parking's user id.
     * @apiSuccess {Integer} typeId Parking's type id.
     * @apiSuccess {Integer} amount Parking's amount.
     * @apiSuccess {Number} rate Parking's rate.
     * @apiSuccess {String} status Parking's status.
     * @apiSuccess {String} createdAt Parking's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "typeId": 2,
     *          "amount": 20000,
     *          "rate": "0.25",
     *          "status": "pending",
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} parking Get list of parkings
     * @apiVersion 1.0.0
     * @apiName GetParkings
     * @apiGroup Parking
     *
     * @apiDescription Get list of parkings.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id Parking's id.
     * @apiSuccess {Integer} Object.userId Parking's user id.
     * @apiSuccess {Integer} Object.typeId Parking's type id.
     * @apiSuccess {Integer} Object.amount Parking's amount.
     * @apiSuccess {Number} Object.rate Parking's rate.
     * @apiSuccess {String} Object.status Parking's status.
     * @apiSuccess {String=pending,active,canceled,completed} Object.status Parking's status.
     * @apiSuccess {String} Object.createdAt Parking's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "userId": 1,
     *              "typeId": 2,
     *              "amount": 20000,
     *              "rate": "0.25",
     *              "status": "pending",
     *              "createdAt": "2017-08-24 11:37:15"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} parking/:id Get parking object
     * @apiVersion 1.0.0
     * @apiName GetParking
     * @apiGroup Parking
     *
     * @apiDescription Get object of parking.
     *
     * @apiParam {Integer} id Identifier of parking object.
     *
     * @apiSuccess {Integer} id Parking's id.
     * @apiSuccess {Integer} userId Parking's user id.
     * @apiSuccess {Integer} typeId Parking's type id.
     * @apiSuccess {Integer} amount Parking's amount.
     * @apiSuccess {Number} rate Parking's rate.
     * @apiSuccess {String=pending,active,canceled,completed} status Parking's status.
     * @apiSuccess {String} createdAt Parking's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "typeId": 2,
     *          "amount": 20000,
     *          "rate": "0.25",
     *          "status": "pending",
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} parking/:id Update parking object
     * @apiVersion 1.0.0
     * @apiName UpdateParking
     * @apiGroup Parking
     *
     * @apiDescription Update object of parking.
     *
     * @apiParam {Integer} id Identifier of parking object.
     *
     * @apiParam {Integer} userId Parking's user id.
     * @apiParam {Integer} typeId Parking's type id.
     * @apiParam {Integer} amount Parking's amount.
     * @apiParam {Number} rate Parking's rate.
     * @apiParam {String=pending,active,canceled,completed} status Parking's status.
     * @apiParam {String} [createdAt] Parking's created at datetime.
     *
     * @apiSuccess {Integer} id Parking's id.
     * @apiSuccess {Integer} userId Parking's user id.
     * @apiSuccess {Integer} typeId Parking's type id.
     * @apiSuccess {Integer} amount Parking's amount.
     * @apiSuccess {Number} rate Parking's rate.
     * @apiSuccess {String} status Parking's status.
     * @apiSuccess {String} createdAt Parking's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "typeId": 2,
     *          "amount": 20000,
     *          "rate": "0.25",
     *          "status": "pending",
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} parking/:id Delete parking object
     * @apiVersion 1.0.0
     * @apiName DeleteParking
     * @apiGroup Parking
     *
     * @apiDescription Delete object of parking.
     *
     * @apiParam {Integer} id Identifier of parking object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
