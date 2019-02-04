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
 * Class SubscriberGroupController
 * @package App\Modules\Subscribe\Controllers
 */
class SubscriberGroupController extends RestController
{
	public $modelClass;

	/**
	 * Init model class.
	 */
	public function init(): void
	{
		$this->modelClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER_GROUP);
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
     * @api {post} subscriber/group Create subscriberGroup
     * @apiVersion 1.0.0
     * @apiName CreateSubscriberGroup
     * @apiGroup SubscriberGroup
     *
     * @apiDescription Create new subscriberGroup object.
     *
     * @apiParam {String} name SubscriberGroup's name.
     *
     * @apiSuccess {Integer} id SubscriberGroup's id.
     * @apiSuccess {String} name SubscriberGroup's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Group 1"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscriber/group Get list of subscriberGroups
     * @apiVersion 1.0.0
     * @apiName GetSubscriberGroups
     * @apiGroup SubscriberGroup
     *
     * @apiDescription Get list of subscriberGroups.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SubscriberGroup's id.
     * @apiSuccess {String} Object.name SubscriberGroup's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "name": "Group 1"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscriber/group/:id Get subscriberGroup object
     * @apiVersion 1.0.0
     * @apiName GetSubscriberGroup
     * @apiGroup SubscriberGroup
     *
     * @apiDescription Get object of subscriberGroup.
     *
     * @apiParam {Integer} id Identifier of subscriberGroup object.
     *
     * @apiSuccess {Integer} id SubscriberGroup's id.
     * @apiSuccess {String} name SubscriberGroup's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Group 1"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} subscriber/group/:id Update subscriberGroup object
     * @apiVersion 1.0.0
     * @apiName UpdateSubscriberGroup
     * @apiGroup SubscriberGroup
     *
     * @apiDescription Update object of subscriberGroup.
     *
     * @apiParam {Integer} id Identifier of subscriberGroup object.
     *
     * @apiParam {String} name SubscriberGroup's name.
     *
     * @apiSuccess {Integer} id SubscriberGroup's id.
     * @apiSuccess {String} name SubscriberGroup's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Group 1"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} subscriber/group/:id Delete subscriberGroup object
     * @apiVersion 1.0.0
     * @apiName DeleteSubscriberGroup
     * @apiGroup SubscriberGroup
     *
     * @apiDescription Delete object of subscriberGroup.
     *
     * @apiParam {Integer} id Identifier of subscriberGroup object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
