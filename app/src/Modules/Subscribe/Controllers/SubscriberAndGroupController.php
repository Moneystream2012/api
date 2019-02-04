<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Controllers;

use App\{
	Components\RestController,
	Modules\Subscribe\Components\SubscribeModelFactory
};
use yii\filters\AccessControl;

/**
 * Class SubscriberAndGroupController
 * @package App\Modules\Subscribe\Controllers
 */
class SubscriberAndGroupController extends RestController
{
	public $modelClass;

	/**
	 * Init model class.
	 */
	public function init(): void
	{
		$this->modelClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER_AND_GROUP);
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
                    'roles' => ['user'],
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
        return parent::verbs();
    }

    /**
     * @api {post} subscriber-and-group Create subscriberAndGroup
     * @apiVersion 1.0.0
     * @apiName CreateSubscriberAndGroup
     * @apiGroup SubscriberAndGroup
     *
     * @apiDescription Create new subscriberAndGroup object.
     *
     * @apiParam {Integer} subscriberId SubscriberAndGroup's subscriber id.
     * @apiParam {Integer} groupId SubscriberAndGroup's group id.
     *
     * @apiSuccess {Integer} id SubscriberAndGroup's id.
     * @apiSuccess {Integer} subscriberId SubscriberAndGroup's subscriber id.
     * @apiSuccess {Integer} groupId SubscriberAndGroup's group id.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "subscriberId": 1,
     *          "groupId": 2
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscriber-and-group Get list of subscriberAndGroups
     * @apiVersion 1.0.0
     * @apiName GetSubscriberAndGroups
     * @apiGroup SubscriberAndGroup
     *
     * @apiDescription Get list of subscriberAndGroups.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SubscriberAndGroup's id.
     * @apiSuccess {Integer} Object.subscriberId SubscriberAndGroup's subscriber id.
     * @apiSuccess {Integer} Object.groupId SubscriberAndGroup's group id.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "subscriberId": 1,
     *              "groupId": 2
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscriber-and-group/:id Get subscriberAndGroup object
     * @apiVersion 1.0.0
     * @apiName GetSubscriberAndGroup
     * @apiGroup SubscriberAndGroup
     *
     * @apiDescription Get object of subscriberAndGroup.
     *
     * @apiParam {Integer} id Identifier of subscriberAndGroup object.
     *
     * @apiSuccess {Integer} id SubscriberAndGroup's id.
     * @apiSuccess {Integer} subscriberId SubscriberAndGroup's subscriber id.
     * @apiSuccess {Integer} groupId SubscriberAndGroup's group id.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "subscriberId": 1,
     *          "groupId": 2
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} subscriber-and-group/:id Update subscriberAndGroup object
     * @apiVersion 1.0.0
     * @apiName UpdateSubscriberAndGroup
     * @apiGroup SubscriberAndGroup
     *
     * @apiDescription Update object of subscriberAndGroup.
     *
     * @apiParam {Integer} id Identifier of subscriberAndGroup object.
     *
     * @apiParam {Integer} subscriberId SubscriberAndGroup's subscriber id.
     * @apiParam {Integer} groupId SubscriberAndGroup's group id.
     *
     * @apiSuccess {Integer} id SubscriberAndGroup's id.
     * @apiSuccess {Integer} subscriberId SubscriberAndGroup's subscriber id.
     * @apiSuccess {Integer} groupId SubscriberAndGroup's group id.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "subscriberId": 1,
     *          "groupId": 2
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} subscriber-and-group/:id Delete subscriberAndGroup object
     * @apiVersion 1.0.0
     * @apiName DeleteSubscriberAndGroup
     * @apiGroup SubscriberAndGroup
     *
     * @apiDescription Delete object of subscriberAndGroup.
     *
     * @apiParam {Integer} id Identifier of subscriberAndGroup object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
