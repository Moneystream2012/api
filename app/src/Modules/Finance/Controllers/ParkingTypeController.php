<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers;

use App\{
    Components\RestController,
    Modules\Finance\Components\FinanceModelFactory,
    Helpers\Arr
};
use yii\filters\AccessControl;

/**
 * Class ParkingTypeController
 * @package App\Modules\Finance\Controllers
 */
class ParkingTypeController extends RestController
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->modelClass = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE);
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
            'except' => ['options', 'index'],
			'rules' => [
				[
					'allow' => true,
					'actions' => ['create', 'update', ],
					'roles' => ['admin'],
				],
			],
		];

		return $behaviors;
	}

    protected function verbs()
    {
        return [
            'create' => ['POST'],
            'index' => ['GET'],
            'update' => ['PUT', 'PATCH'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return Arr::removeSeveral(parent::actions(), ['view', 'delete']);
    }

    /**
     * @api {post} parking/type Create parking type
     * @apiVersion 1.0.0
     * @apiName CreateParkingType
     * @apiGroup ParkingType
     *
     * @apiDescription Create new parking type object.
     *
     * @apiParam {String} name ParkingType's name.
     * @apiParam {Number} rate ParkingType's rate.
     * @apiParam {Integer} period ParkingType's period.
     *
     * @apiSuccess {Integer} id ParkingType's id.
     * @apiSuccess {String} name ParkingType's name.
     * @apiSuccess {Number} rate ParkingType's rate.
     * @apiSuccess {Integer} period ParkingType's period.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "weekly",
     *          "rate": "0.25",
     *          "period": 7
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} parking/type Get list of parking types
     * @apiVersion 1.0.0
     * @apiName GetParkingTypes
     * @apiGroup ParkingType
     *
     * @apiDescription Get list of parking types.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id ParkingType's id.
     * @apiSuccess {String} Object.name ParkingType's name.
     * @apiSuccess {Number} Object.rate ParkingType's rate.
     * @apiSuccess {Integer} Object.period ParkingType's period.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "name": "weekly",
     *              "rate": "0.25",
     *              "period": 7
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} parking/type/:id Get parking type object
     * @apiVersion 1.0.0
     * @apiName GetParkingType
     * @apiGroup ParkingType
     *
     * @apiDescription Get object of parking type.
     *
     * @apiSuccess {Integer} id ParkingType's id.
     * @apiSuccess {String} name ParkingType's name.
     * @apiSuccess {Number} rate ParkingType's rate.
     * @apiSuccess {Integer} period ParkingType's period.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "weekly",
     *          "rate": "0.25",
     *          "period": 7
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} parking/type/:id Update parking type object
     * @apiVersion 1.0.0
     * @apiName UpdateParkingType
     * @apiGroup ParkingType
     *
     * @apiDescription Update object of parking type.
     *
     * @apiParam {String} name ParkingType's name.
     * @apiParam {Number} rate ParkingType's rate.
     * @apiParam {Integer} period ParkingType's period.
     *
     * @apiSuccess {Integer} id ParkingType's id.
     * @apiSuccess {String} name ParkingType's name.
     * @apiSuccess {Number} rate ParkingType's rate.
     * @apiSuccess {Integer} period ParkingType's period.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "weekly",
     *          "rate": "0.25",
     *          "period": 7
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} parking/type/:id Delete parking type object
     * @apiVersion 1.0.0
     * @apiName DeleteParkingType
     * @apiGroup ParkingType
     *
     * @apiDescription Delete object of parking type.
     *
     * @apiParam {Integer} id Identifier of parking type object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
