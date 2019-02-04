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
    Helpers\Arr
};
use yii\filters\AccessControl;

/**
 * Class MessageAttachmentController
 * @package App\Modules\Support\Controllers
 */
class MessageAttachmentController extends RestController
{
	public $modelClass;

	/**
	 * Init model class
	 */
	public function init(): void
	{
		$this->modelClass = SupportModelFactory::getClass(SupportModelFactory::MESSAGE_ATTACHMENT);
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
        return Arr::removeSeveral(parent::actions(), ['update']);
    }

    /**
     * @api {post} support/message-attachment Create supportMessageAttachment
     * @apiVersion 1.0.0
     * @apiName CreateSupportMessageAttachment
     * @apiGroup SupportMessageAttachment
     *
     * @apiDescription Create new supportMessageAttachment object.
     *
     * @apiParam {Integer} messageId SupportMessageAttachment's message id.
     * @apiParam {String=file,image} type SupportMessageAttachment's type.
     * @apiParam {String} filename SupportMessageAttachment's filename.
     * @apiParam {String} [createdAt] SupportMessageAttachment's created at datetime.
     *
     * @apiSuccess {Integer} id SupportMessageAttachment's id.
     * @apiSuccess {Integer} messageId SupportMessageAttachment's message id.
     * @apiSuccess {String=file,image} type SupportMessageAttachment's type.
     * @apiSuccess {String} filename SupportMessageAttachment's filename.
     * @apiSuccess {String} createdAt SupportMessageAttachment's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "messageId": 1,
     *          "type": "image",
     *          "filename": "my_attachment_001.jpg",
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} support/message-attachment Get list of supportMessageAttachments
     * @apiVersion 1.0.0
     * @apiName GetSupportMessageAttachments
     * @apiGroup SupportMessageAttachment
     *
     * @apiDescription Get list of supportMessageAttachments.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SupportMessageAttachment's id.
     * @apiSuccess {Integer} Object.messageId SupportMessageAttachment's message id.
     * @apiSuccess {String=file,image} Object.type SupportMessageAttachment's type.
     * @apiSuccess {String} Object.filename SupportMessageAttachment's filename.
     * @apiSuccess {String} Object.createdAt SupportMessageAttachment's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "messageId": 1,
     *              "type": "image",
     *              "filename": "my_attachment_001.jpg",
     *              "createdAt": "2017-08-24 11:37:15"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} support/message-attachment/:id Get supportMessageAttachment object
     * @apiVersion 1.0.0
     * @apiName GetSupportMessageAttachment
     * @apiGroup SupportMessageAttachment
     *
     * @apiDescription Get object of supportMessageAttachment.
     *
     * @apiParam {Integer} id Identifier of supportMessageAttachment object.
     *
     * @apiSuccess {Integer} id SupportMessageAttachment's id.
     * @apiSuccess {Integer} messageId SupportMessageAttachment's message id.
     * @apiSuccess {String=file,image} type SupportMessageAttachment's type.
     * @apiSuccess {String} filename SupportMessageAttachment's filename.
     * @apiSuccess {String} createdAt SupportMessageAttachment's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "messageId": 1,
     *          "type": "image",
     *          "filename": "my_attachment_001.jpg",
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} support/message-attachment/:id Update supportMessageAttachment object
     * @apiVersion 1.0.0
     * @apiName UpdateSupportMessageAttachment
     * @apiGroup SupportMessageAttachment
     *
     * @apiDescription Update object of supportMessageAttachment.
     *
     * @apiParam {Integer} id Identifier of supportMessageAttachment object.
     *
     * @apiParam {Integer} messageId SupportMessageAttachment's message id.
     * @apiParam {String=file,image} type SupportMessageAttachment's type.
     * @apiParam {String} filename SupportMessageAttachment's filename.
     * @apiParam {String} [createdAt] SupportMessageAttachment's created at datetime.
     *
     * @apiSuccess {Integer} id SupportMessageAttachment's id.
     * @apiSuccess {Integer} messageId SupportMessageAttachment's message id.
     * @apiSuccess {String=file,image} type SupportMessageAttachment's type.
     * @apiSuccess {String} filename SupportMessageAttachment's filename.
     * @apiSuccess {String} createdAt SupportMessageAttachment's created at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "messageId": 1,
     *          "type": "image",
     *          "filename": "my_attachment_001.jpg",
     *          "createdAt": "2017-08-24 11:37:15"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} support/message-attachment/:id Delete supportMessageAttachment object
     * @apiVersion 1.0.0
     * @apiName DeleteSupportMessageAttachment
     * @apiGroup SupportMessageAttachment
     *
     * @apiDescription Delete object of supportMessageAttachment.
     *
     * @apiParam {Integer} id Identifier of supportMessageAttachment object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
