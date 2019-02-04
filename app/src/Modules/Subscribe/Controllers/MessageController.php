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
 * Class MessageController
 * @package App\Modules\Subscribe\Controllers
 */
class MessageController extends RestController
{
	public $modelClass;

	/**
	 * Init model class
	 */
	public function init(): void
	{
		$this->modelClass = SubscribeModelFactory::getClass(SubscribeModelFactory::MESSAGE);
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
     * @api {post} subscribe/message Create subscribeMessage
     * @apiVersion 1.0.0
     * @apiName CreateSubscribeMessage
     * @apiGroup SubscribeMessage
     *
     * @apiDescription Create new subscribeMessage object.
     *
     * @apiParam {String} title SubscribeMessage's title.
     * @apiParam {String} content SubscribeMessage's content.
     * @apiParam {Integer} authorId SubscribeMessage's author id.
     * @apiParam {Integer} groupId SubscribeMessage's group id.
     * @apiParam {String} [createdAt] SubscribeMessage's created at datetime.
     *
     * @apiSuccess {Integer} id SubscribeMessage's id.
     * @apiSuccess {String} title SubscribeMessage's title.
     * @apiSuccess {String} content SubscribeMessage's content.
     * @apiSuccess {Integer} authorId SubscribeMessage's author id.
     * @apiSuccess {Integer} groupId SubscribeMessage's group id.
     * @apiSuccess {String} createdAt SubscribeMessage's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "title": "Greeting from referer!",
     *          "content": "Lets mining minexcoin",
     *          "authorId": 1,
     *          "groupId": 2,
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscribe/message Get list of subscribeMessages
     * @apiVersion 1.0.0
     * @apiName GetSubscribeMessages
     * @apiGroup SubscribeMessage
     *
     * @apiDescription Get list of subscribeMessages.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SubscribeMessage's id.
     * @apiSuccess {String} Object.title SubscribeMessage's title.
     * @apiSuccess {String} Object.content SubscribeMessage's content.
     * @apiSuccess {Integer} Object.authorId SubscribeMessage's author id.
     * @apiSuccess {Integer} Object.groupId SubscribeMessage's group id.
     * @apiSuccess {String} Object.createdAt SubscribeMessage's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "title": "Greeting from referer!",
     *              "content": "Lets mining minexcoin",
     *              "authorId": 1,
     *              "groupId": 2,
     *              "createdAt": "2017-08-24 11:37:15"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscribe/message/:id Get subscribeMessage object
     * @apiVersion 1.0.0
     * @apiName GetSubscribeMessage
     * @apiGroup SubscribeMessage
     *
     * @apiDescription Get object of subscribeMessage.
     *
     * @apiParam {Integer} id Identifier of subscribeMessage object.
     *
     * @apiSuccess {Integer} id SubscribeMessage's id.
     * @apiSuccess {String} title SubscribeMessage's title.
     * @apiSuccess {String} content SubscribeMessage's content.
     * @apiSuccess {Integer} authorId SubscribeMessage's author id.
     * @apiSuccess {Integer} groupId SubscribeMessage's group id.
     * @apiSuccess {String} createdAt SubscribeMessage's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "title": "Greeting from referer!",
     *          "content": "Lets mining minexcoin",
     *          "authorId": 1,
     *          "groupId": 2,
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} subscribe/message/:id Update subscribeMessage object
     * @apiVersion 1.0.0
     * @apiName UpdateSubscribeMessage
     * @apiGroup SubscribeMessage
     *
     * @apiDescription Update object of subscribeMessage.
     *
     * @apiParam {Integer} id Identifier of subscribeMessage object.
     *
     * @apiParam {String} title SubscribeMessage's title.
     * @apiParam {String} content SubscribeMessage's content.
     * @apiParam {Integer} authorId SubscribeMessage's author id.
     * @apiParam {Integer} groupId SubscribeMessage's group id.
     * @apiParam {String} [createdAt] SubscribeMessage's created at datetime.
     *
     * @apiSuccess {Integer} id SubscribeMessage's id.
     * @apiSuccess {String} title SubscribeMessage's title.
     * @apiSuccess {String} content SubscribeMessage's content.
     * @apiSuccess {Integer} authorId SubscribeMessage's author id.
     * @apiSuccess {Integer} groupId SubscribeMessage's group id.
     * @apiSuccess {String} createdAt SubscribeMessage's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "title": "Greeting from referer!",
     *          "content": "Lets mining minexcoin",
     *          "authorId": 1,
     *          "groupId": 2,
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} subscribe/message/:id Delete subscribeMessage object
     * @apiVersion 1.0.0
     * @apiName DeleteSubscribeMessage
     * @apiGroup SubscribeMessage
     *
     * @apiDescription Delete object of subscribeMessage.
     *
     * @apiParam {Integer} id Identifier of subscribeMessage object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
