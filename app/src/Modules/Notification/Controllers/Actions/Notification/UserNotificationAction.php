<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Notification\Controllers\Actions\Notification;

use yii\data\ActiveDataProvider;
use yii\rest;
use App\Modules\Notification\Models\Notification;

/**
 * Class UserNotificationAction
 * @package App\Modules\Notification\Controllers\Actions\UserNotification
 *
 * @api {get} notification/user?mode=count Get current user notification's
 * @apiVersion 1.0.0
 * @apiName GetUserNotification
 * @apiGroup UserNotification
 *
 * @apiParam {String=count} [mode] Do UserNotification's counting (seen, not seen) or not.
 * @apiParam {String=true,false} [seen] What kind of notifications will listed (true: seen, false: non-seen, null: all)
 *
 * @apiSuccess {Array} Array UserNotification's data.
 * @apiSuccess {Integer} Array.seenCnt Count of seen by current user notifications.
 * @apiSuccess {Integer} Array.notSeenCnt Count of not seen by current user notifications.
 * @apiSuccess {Array} Array.notifications List of notification Object's for current user.
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
 *		HTTP/1.1 200 OK
 *		{
 *          "seenCnt": 0,
 *          "notSeenCnt": 2,
 *          "notifications": [
 *              {
 *                  "_id": {
 *                      "$oid": "597f1b5ab86024002c3b47e4"
 *                  },
 *                  "title": "222",
 *                  "content": "111111111111",
 *                  "type": "error",
 *                  "postedFor": [],
 *                  "seenBy": [1,3,2],
 *                  "moderatorId": 1,
 *                  "createdAt": "2017-07-22 17:19:29",
 *                  "updatedAt": "2017-07-22 17:19:31",
 *              },
 *              {
 *                  "_id": {
 *                      "$oid": "597f3442b86024002c3b47e5"
 *                  },
 *                  "title": "222",
 *                  "content": "111111111111",
 *                  "type": "error",
 *                  "postedFor": [5],
 *                  "seenBy": [],
 *                  "moderatorId": 1,
 *                  "createdAt": "2017-07-22 17:19:29",
 *                  "updatedAt": "2017-07-22 17:19:31",
 *              }
 *          ]
 *      }
 *
 * @apiUse NotFoundError
 * @apiUse UnavailableError
 * @apiUse UnauthorisedError
 */
class UserNotificationAction extends rest\Action
{
    /**
     * @inheritdoc
     */
    public function run() {

        $userId = Notification::getUserId();

	    $result = \Yii::createObject([
		    'class' => ActiveDataProvider::class,
		    'query' => $this->modelClass::find()
			    ->postedFor($userId),
            'sort' => [
                'defaultOrder' => [
                    'createdAt' => SORT_DESC
                ]
            ]
	    ]);

	    return $result;
    }
}