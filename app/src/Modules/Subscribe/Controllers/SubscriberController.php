<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Controllers;

use App\{
    Components\RestController, Helpers\Arr, Modules\Subscribe\Components\SubscribeModelFactory, Modules\Subscribe\Controllers\Actions\Subscriber\CheckAction, Modules\Subscribe\Controllers\Actions\Subscriber\CreateAction, Modules\Subscribe\Controllers\Actions\Subscriber\DeleteAction
};
use yii\filters\AccessControl;

/**
 * Class SubscriberController
 * @package App\Modules\Subscribe\Controllers
 */
class SubscriberController extends RestController
{
	public $modelClass;

	/**
	 * Init model class.
	 */
	public function init(): void
	{
		$this->modelClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER);
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
                    'actions' => ['create'],
                ],
                [
                    'allow' => true,
                    'actions' => ['delete'],
                    'roles' => ['user'],
                ],
                [
                    'allow' => true,
                    'actions' => ['check'],
                    'roles' => ['user'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index'],
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
            'create' => ['POST'],
            'check' => ['POST'],
            'index' => ['GET'],
            'delete' => ['DELETE'],
        ];
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = Arr::removeSeveral(parent::actions(), ['view', 'update', 'create']);

        return array_merge($actions, [
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => $this->modelClass
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass,
            ],
            'check' => [
                'class' => CheckAction::class,
                'modelClass' => $this->modelClass
            ]
        ]);
    }

    /**
     * @api {post} subscriber Create subscriber
     * @apiVersion 1.0.0
     * @apiName CreateSubscriber
     * @apiGroup Subscriber
     *
     * @apiDescription Create new subscriber object.
     *
     * @apiParam {Integer} userId Subscriber's user id.
     * @apiParam {Integer} sourceId Subscriber's source id.
     * @apiParam {String} [createdAt] Subscriber's created at datetime.
     *
     * @apiSuccess {Integer} id Subscriber's id.
     * @apiSuccess {Integer} userId Subscriber's user id.
     * @apiSuccess {Integer} sourceId Subscriber's source id.
     * @apiSuccess {String} createdAt Subscriber's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "sourceId": 2,
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscriber Get list of subscribers
     * @apiVersion 1.0.0
     * @apiName GetSubscribers
     * @apiGroup Subscriber
     *
     * @apiDescription Get list of subscribers.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id Subscriber's id.
     * @apiSuccess {Integer} Object.userId Subscriber's user id.
     * @apiSuccess {Integer} Object.sourceId Subscriber's source id.
     * @apiSuccess {String} Object.createdAt Subscriber's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "userId": 1,
     *              "sourceId": 2,
     *              "createdAt": "2017-08-24 11:37:15"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscriber/:id Get subscriber object
     * @apiVersion 1.0.0
     * @apiName GetSubscriber
     * @apiGroup Subscriber
     *
     * @apiDescription Get object of subscriber.
     *
     * @apiParam {Integer} id Identifier of subscriber object.
     *
     * @apiSuccess {Integer} id Subscriber's id.
     * @apiSuccess {Integer} userId Subscriber's user id.
     * @apiSuccess {Integer} sourceId Subscriber's source id.
     * @apiSuccess {String} createdAt Subscriber's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "sourceId": 2,
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} subscriber/:id Update subscriber object
     * @apiVersion 1.0.0
     * @apiName UpdateSubscriber
     * @apiGroup Subscriber
     *
     * @apiDescription Update object of subscriber.
     *
     * @apiParam {Integer} id Identifier of subscriber object.
     *
     * @apiParam {Integer} userId Subscriber's user id.
     * @apiParam {Integer} sourceId Subscriber's source id.
     * @apiParam {String} [createdAt] Subscriber's created at datetime.
     *
     * @apiSuccess {Integer} id Subscriber's id.
     * @apiSuccess {Integer} userId Subscriber's user id.
     * @apiSuccess {Integer} sourceId Subscriber's source id.
     * @apiSuccess {String} createdAt Subscriber's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "sourceId": 2,
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} subscriber/:id Delete subscriber object
     * @apiVersion 1.0.0
     * @apiName DeleteSubscriber
     * @apiGroup Subscriber
     *
     * @apiDescription Delete object of subscriber.
     *
     * @apiParam {Integer} id Identifier of subscriber object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
