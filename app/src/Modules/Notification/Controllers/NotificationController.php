<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Notification\Controllers;

use App\{
	Components\RestController,
	Modules\Notification\Components\NotificationModelFactory,
    Modules\Notification\Controllers\Actions\Notification\UserNotificationAction,
    Modules\Notification\Controllers\Actions\Notification\CreateNotificationAction,
    Modules\Notification\Controllers\Actions\Notification\SeenStatusAction,
    Helpers\Arr
};
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\IndexAction;

/**
 * Class NotificationController
 * @package App\Modules\Notification\Controllers
 */
class NotificationController extends RestController
{
	public $modelClass;

	/**
	 * Init model class
	 */
	public function init(): void
	{
		$this->modelClass = NotificationModelFactory::getClass(NotificationModelFactory::NOTIFICATION);
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
                    'actions' => ['index','create'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['user', 'seen'],
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
        return [
            'create' => ['POST'],
            'user' => ['GET'],
            'index' => ['GET'],
            'seen' => ['POST']
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $actions = [
            'user' => [
                'class' => UserNotificationAction::class,
                'modelClass' => new $this->modelClass,
            ],
            'create' => [
                'class' => CreateNotificationAction::class,
                'modelClass' => new $this->modelClass,
            ],
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function ($action) {
                    /* @var $modelClass \yii\db\BaseActiveRecord */
                    $modelClass = $action->modelClass;

                    return Yii::createObject([
                        'class' => ActiveDataProvider::className(),
                        'query' => $modelClass::find(),
                        'sort' => [
                            'defaultOrder' => [
                                'createdAt' => SORT_DESC
                            ]
                        ]
                    ]);
                }
            ],
            'seen' => [
                'class' => SeenStatusAction::class,
                'modelClass' => $this->modelClass
            ]
        ];
        return Arr::merge(
            Arr::removeSeveral(parent::actions(), ['view', 'update', 'delete', 'create']),
            $actions
        );
    }

    /**
     * @api {post} notification Create notification
     * @apiVersion 1.0.0
     * @apiName CreateNotification
     * @apiGroup Notification
     *
     * @apiDescription Create new notification object.
     *
     * @apiParam {String} title Notification's title.
     * @apiParam {String} content Notification's content.
     * @apiParam {String=info,warn,error} type Notification's type.
     * @apiParam {Integer[]} [postedFor] Notification's for user id posted, empty array for broadcast.
     * @apiParam {Integer[]} [seenBy] Notification's by user id seen.
     * @apiParam {Integer} moderatorId Notification's moderator id.
     * @apiParam {String} [createdAt] Notification's created at datetime.
     * @apiParam {String} [updatedAt] Notification's updatedAt at datetime.
     *
     * @apiSuccess {Integer} _id Notification's id.
     * @apiSuccess {String} title Notification's title.
     * @apiSuccess {String} content Notification's content.
     * @apiSuccess {String=info,warn,error} type Notification's type.
     * @apiSuccess {Integer[]} postedFor Notification's for user id posted, empty array for broadcast.
     * @apiSuccess {Integer[]} seenBy Notification's by user id seen.
     * @apiSuccess {Integer} moderatorId Notification's moderator id.
     * @apiSuccess {String} createdAt Notification's created at datetime.
     * @apiSuccess {String} updatedAt Notification's updatedAt at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_id": "597a1e9bb8602400166a3ab2",
     *          "title": "Income",
     *          "content": "You getting income 20 MNX on your balance",
     *          "type": "info",
     *          "postedFor": [3,4,5],
     * 			"seenBy": [3,4],
     *          "moderatorId": 1,
     *          "createdAt": "2017-08-24 11:37:15",
     *          "updatedAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} notification Get list of notifications
     * @apiVersion 1.0.0
     * @apiName GetNotifications
     * @apiGroup Notification
     *
     * @apiDescription Get list of notifications.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object._id Notification's id.
     * @apiSuccess {String} Object.title Notification's title.
     * @apiSuccess {String} Object.content Notification's content.
     * @apiSuccess {String=info,warn,error} Object.type Notification's type.
     * @apiSuccess {Integer[]} Object.postedFor Notification's for user id posted, empty array for broadcast.
     * @apiSuccess {Integer[]} Object.seenBy Notification's by user id seen.
     * @apiSuccess {Integer} Object.moderatorId Notification's moderator id.
     * @apiSuccess {String} Object.createdAt Notification's created at datetime.
     * @apiSuccess {String} Object.updatedAt Notification's updatedAt at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "_id": "597a1e9bb8602400166a3ab2",
     *              "title": "Income",
     *              "content": "You getting income 20 MNX on your balance",
     *              "type": "info",
     *              "postedFor": [3,4,5],
     * 			    "seenBy": [3,4],
     *              "moderatorId": 1,
     *              "createdAt": "2017-08-24 11:37:15",
     *              "updatedAt": "2017-08-24 11:37:15"
     *          }
     *     ]
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} notification/:_id Get notification object
     * @apiVersion 1.0.0
     * @apiName GetNotification
     * @apiGroup Notification
     *
     * @apiDescription Get object of notification.
     *
     * @apiParam {Integer} _id Identifier of notification object.
     *
     * @apiSuccess {Integer} _id Notification's id.
     * @apiSuccess {String} title Notification's title.
     * @apiSuccess {String} content Notification's content.
     * @apiSuccess {String=info,warn,error} type Notification's type.
     * @apiSuccess {Integer[]} postedFor Notification's for user id posted, empty array for broadcast.
     * @apiSuccess {Integer[]} seenBy Notification's by user id seen.
     * @apiSuccess {Integer} moderatorId Notification's moderator id.
     * @apiSuccess {String} createdAt Notification's created at datetime.
     * @apiSuccess {String} updatedAt Notification's updatedAt at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_id": "597a1e9bb8602400166a3ab2",
     *          "title": "Income",
     *          "content": "You getting income 20 MNX on your balance",
     *          "type": "info",
     *          "postedFor": [3,4,5],
     * 			"seenBy": [3,4],
     *          "moderatorId": 1,
     *          "createdAt": "2017-08-24 11:37:15",
     *          "updatedAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} notification/:_id Update notification object
     * @apiVersion 1.0.0
     * @apiName UpdateNotification
     * @apiGroup Notification
     *
     * @apiDescription Update object of notification.
     *
     * @apiParam {Integer} _id Identifier of notification object.
     *
     * @apiParam {String} title Notification's title.
     * @apiParam {String} content Notification's content.
     * @apiParam {String=info,warn,error} type Notification's type.
     * @apiParam {Integer[]} [postedFor] Notification's for user id posted, empty array for broadcast.
     * @apiParam {Integer[]} [seenBy] Notification's by user id seen.
     * @apiParam {Integer} moderatorId Notification's moderator id.
     * @apiParam {String} [createdAt] Notification's created at datetime.
     * @apiParam {String} [updatedAt] Notification's updatedAt at datetime.
     *
     * @apiSuccess {Integer} _id Notification's id.
     * @apiSuccess {String} title Notification's title.
     * @apiSuccess {String} content Notification's content.
     * @apiSuccess {String=info,warn,error} type Notification's type.
     * @apiSuccess {Integer[]} postedFor Notification's for user id posted, empty array for broadcast.
     * @apiSuccess {Integer[]} seenBy Notification's by user id seen.
     * @apiSuccess {Integer} moderatorId Notification's moderator id.
     * @apiSuccess {String} createdAt Notification's created at datetime.
     * @apiSuccess {String} updatedAt Notification's updatedAt at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_id": "597a1e9bb8602400166a3ab2",
     *          "title": "Income",
     *          "content": "You getting income 20 MNX on your balance",
     *          "type": "info",
     *          "postedFor": [3,4,5],
     * 			"seenBy": [3,4],
     *          "moderatorId": 1,
     *          "createdAt": "2017-08-24 11:37:15",
     *          "updatedAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} notification/:_id Delete notification object
     * @apiVersion 1.0.0
     * @apiName DeleteNotification
     * @apiGroup Notification
     *
     * @apiDescription Delete object of notification.
     *
     * @apiParam {Integer} _id Identifier of notification object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}