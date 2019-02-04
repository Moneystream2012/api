<?php
/**
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 26.07.17
 * Time: 16:43
 */
declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use yii\rest;
use yii\web\ForbiddenHttpException;

/**
 * Class UserParkingAction
 * @package App\Modules\Finance\Controllers\Actions\Parking
 *
 * @api {get} user-parking Get list of user's parkings
 * @apiVersion 1.0.0
 * @apiName GetUserParking
 * @apiGroup Parking
 *
 * @apiSuccess {Integer} id Parking identifier.
 * @apiSuccess {Integer} typeId Type identifier.
 * @apiSuccess {Integer} amount Amount of coins was parked.
 * @apiSuccess {Float} rate Rate value was during creation.
 * @apiSuccess {String} createdAt Date and time of parking creation.
 * @apiSuccess {String} status Current status of parking.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     [
 *          {
 *              "id": 1,
 *              "typeId": 3,
 *              "amount": 56946512,
 *              "rate": 45.5,
 *              "createdAt": "2017-07-26 17:34:46",
 *              "status": "active"
 *          }
 *     ]
 *
 * @apiUse NotFoundError
 * @apiUse UnauthorisedError
 * @apiUse UnavailableError
 */
class UserParkingAction extends rest\Action
{
	/**
	 * @inheritdoc
	 */
	public function run(): array
	{
		$model = $this->modelClass->find()
            ->select(['id', 'typeId', 'amount', 'rate', 'createdAt', 'status'])
			->ownedBy(\Yii::$app->user->id)
            ->asArray()
            ->all();

		return $model;
	}
}