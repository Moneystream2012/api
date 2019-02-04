<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support\Controllers;

use App\{
	Components\RestController,
	Modules\Support\Components\SupportModelFactory,
	Modules\Support\Controllers\Actions\Message\UserMessageAction,
    Helpers\Arr
};
use yii\filters\AccessControl;

/**
 * Class MessageController
 * @package App\Modules\Support\Controllers
 */
class MessageController extends RestController
{
	public $modelClass;

	/**
	 * Init model class
	 */
	public function init(): void
	{
		$this->modelClass = SupportModelFactory::getClass(SupportModelFactory::MESSAGE);
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
                    'actions' => ['index', 'view', 'create', 'delete'],
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
     * @inheritdoc
     */
    public function actions(): array
    {
        $actions = [
            'user-message' => [
                'class' => UserMessageAction::class,
                'modelClass' => new $this->modelClass,
            ],
        ];
        return Arr::merge(
            Arr::removeSeveral(parent::actions(), ['update']),
            $actions
        );
    }

    /**
     * @api {post} support/message Create supportMessage
     * @apiVersion 1.0.0
     * @apiName CreateSupportMessage
     * @apiGroup SupportMessage
     *
     * @apiDescription Create new supportMessage object.
     *
     * @apiParam {Integer} senderId SupportMessage's sender user id.
     * @apiParam {Integer} receiverId SupportMessage's sender user id.
     * @apiParam {String} content SupportMessage's content.
     * @apiParam {String} [createdAt] SupportMessage's created at datetime.
     * @apiParam {Integer} [seen=0] SupportMessage's is message seen by receiver.
     *
     * @apiSuccess {Integer} id SupportMessage's id.
     * @apiSuccess {Integer} senderId SupportMessage's sender user id.
     * @apiSuccess {Integer} receiverId SupportMessage's sender user id.
     * @apiSuccess {String} content SupportMessage's content.
     * @apiSuccess {String} createdAt SupportMessage's created at datetime.
     * @apiSuccess {Integer} seen SupportMessage's is message seen by receiver.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "senderId": 1,
     *          "receiverId": 1,
     *          "content": "Greeting from support!",
     *          "createdAt": "2017-08-24 11:37:15",
     *          "seen": 1
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} support/message Get list of supportMessages
     * @apiVersion 1.0.0
     * @apiName GetSupportMessages
     * @apiGroup SupportMessage
     *
     * @apiDescription Get list of supportMessages.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SupportMessage's id.
     * @apiSuccess {Integer} Object.senderId SupportMessage's sender user id.
     * @apiSuccess {Integer} Object.receiverId SupportMessage's sender user id.
     * @apiSuccess {String} Object.content SupportMessage's content.
     * @apiSuccess {String} Object.createdAt SupportMessage's created at datetime.
     * @apiSuccess {Integer} Object.seen SupportMessage's is message seen by receiver.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "senderId": 1,
     *              "receiverId": 1,
     *              "content": "Greeting from support!",
     *              "createdAt": "2017-08-24 11:37:15",
     *              "seen": 1
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} support/message/:id Get supportMessage object
     * @apiVersion 1.0.0
     * @apiName GetSupportMessage
     * @apiGroup SupportMessage
     *
     * @apiDescription Get object of supportMessage.
     *
     * @apiParam {Integer} id Identifier of supportMessage object.
     *
     * @apiSuccess {Integer} id SupportMessage's id.
     * @apiSuccess {Integer} senderId SupportMessage's sender user id.
     * @apiSuccess {Integer} receiverId SupportMessage's sender user id.
     * @apiSuccess {String} content SupportMessage's content.
     * @apiSuccess {String} createdAt SupportMessage's created at datetime.
     * @apiSuccess {Integer} seen SupportMessage's is message seen by receiver.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "senderId": 1,
     *          "receiverId": 1,
     *          "content": "Greeting from support!",
     *          "createdAt": "2017-08-24 11:37:15",
     *          "seen": 1
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} support/message/:id Update supportMessage object
     * @apiVersion 1.0.0
     * @apiName UpdateSupportMessage
     * @apiGroup SupportMessage
     *
     * @apiDescription Update object of supportMessage.
     *
     * @apiParam {Integer} id Identifier of supportMessage object.
     *
     * @apiParam {Integer} senderId SupportMessage's sender user id.
     * @apiParam {Integer} receiverId SupportMessage's sender user id.
     * @apiParam {String} content SupportMessage's content.
     * @apiParam {String} [createdAt] SupportMessage's created at datetime.
     * @apiParam {Integer} seen SupportMessage's is message seen by receiver.
     *
     * @apiSuccess {Integer} id SupportMessage's id.
     * @apiSuccess {Integer} senderId SupportMessage's sender user id.
     * @apiSuccess {Integer} receiverId SupportMessage's sender user id.
     * @apiSuccess {String} content SupportMessage's content.
     * @apiSuccess {String} createdAt SupportMessage's created at datetime.
     * @apiSuccess {Integer} seen SupportMessage's is message seen by receiver.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "senderId": 1,
     *          "receiverId": 1,
     *          "content": "Greeting from support!",
     *          "createdAt": "2017-08-24 11:37:15",
     *          "seen": 1
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} support/message/:id Delete supportMessage object
     * @apiVersion 1.0.0
     * @apiName DeleteSupportMessage
     * @apiGroup SupportMessage
     *
     * @apiDescription Delete object of supportMessage.
     *
     * @apiParam {Integer} id Identifier of supportMessage object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
