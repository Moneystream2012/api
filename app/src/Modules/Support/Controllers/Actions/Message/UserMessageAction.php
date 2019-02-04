<?php
/**
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 27.07.17
 * Time: 15:33
 */
declare(strict_types=1);

namespace App\Modules\Support\Controllers\Actions\Message;

use yii\rest;

/**
 * Class UserMessageAction
 * @package App\Modules\Support\Controllers\Actions\Message
 *
 * @api {get} user-message Get list of messages by user id
 * @apiVersion 1.0.0
 * @apiName GetUserMessages
 * @apiGroup Message
 *
 * @apiSuccess {Integer} id Message <code>id</code>.
 * @apiSuccess {Integer} senderId User <code>id</code> who sent.
 * @apiSuccess {Integer} receiverId User <code>id</code> who has received.
 * @apiSuccess {String} content Message content.
 * @apiSuccess {String} createdAt Date and time message was created.
 * @apiSuccess {Integer} seen Tumbler to mark message as unseen or seen.
 *
 * @apiSuccessExample Success-Response:
 *		HTTP/1.1 200 OK
 *		[
 *			{
 *              "id": 1,
 * 				"senderId": 1,
 * 				"receiverId": 2,
 * 				"content": "Content of message",
 * 				"createdAt": "2017-27-07 15:37:21",
 * 				"seen": 0
 *			}
 *		]
 *
 * @apiUse NotFoundError
 * @apiUse UnavailableError
 * @apiUse UnauthorisedError
 */
class UserMessageAction extends rest\Action
{
    /**
     * @inheritdoc
     */
    public function run(): array
    {
        return $this->modelClass->find()->orderedByCreation(SORT_ASC)->asArray()->all();
    }
}