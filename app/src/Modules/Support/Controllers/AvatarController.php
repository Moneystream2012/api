<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support\Controllers;

use App\{
    Components\RestController, Helpers\Arr, Modules\Support\Components\SupportModelFactory, Modules\Support\Controllers\Actions\Avatar\UserAvatarAction
};
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class AvatarController
 * @package App\Modules\Support\Controllers
 */
class AvatarController extends RestController
{
	public $modelClass;

	/**
	 * Init model class
	 */
	public function init(): void
	{
		$this->modelClass = SupportModelFactory::getClass(SupportModelFactory::AVATAR);
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
                    'actions' => ['index', 'view', 'create', 'update', 'delete', 'user-avatar'],
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
        return Arr::merge(parent::verbs(), [
            'user-avatar' => ['GET']
        ]);
    }

    /**
     * @api {post} support/avatar Create supportAvatar
     * @apiVersion 1.0.0
     * @apiName CreateSupportAvatar
     * @apiGroup SupportAvatar
     *
     * @apiDescription Create new supportAvatar object.
     *
     * @apiParam {Integer} userId SupportAvatar's user id.
     * @apiParam {String} filename SupportAvatar's filename.
     *
     * @apiSuccess {Integer} id SupportAvatar's id.
     * @apiSuccess {Integer} userId SupportAvatar's user id.
     * @apiSuccess {String} filename SupportAvatar's filename.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "filename": "my_avatar_001.jpg"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} support/avatar Get list of supportAvatars
     * @apiVersion 1.0.0
     * @apiName GetSupportAvatars
     * @apiGroup SupportAvatar
     *
     * @apiDescription Get list of supportAvatars.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SupportAvatar's id.
     * @apiSuccess {Integer} Object.userId SupportAvatar's user id.
     * @apiSuccess {String} Object.filename SupportAvatar's filename.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "userId": 1,
     *              "filename": "my_avatar_001.jpg"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} support/avatar/:id Get supportAvatar object
     * @apiVersion 1.0.0
     * @apiName GetSupportAvatar
     * @apiGroup SupportAvatar
     *
     * @apiDescription Get object of supportAvatar.
     *
     * @apiParam {Integer} id Identifier of supportAvatar object.
     *
     * @apiSuccess {Integer} id SupportAvatar's id.
     * @apiSuccess {Integer} userId SupportAvatar's user id.
     * @apiSuccess {String} filename SupportAvatar's filename.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "filename": "my_avatar_001.jpg"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} support/avatar/:id Update supportAvatar object
     * @apiVersion 1.0.0
     * @apiName UpdateSupportAvatar
     * @apiGroup SupportAvatar
     *
     * @apiDescription Update object of supportAvatar.
     *
     * @apiParam {Integer} id Identifier of supportAvatar object.
     *
     * @apiParam {Integer} userId SupportAvatar's user id.
     * @apiParam {String} filename SupportAvatar's filename.
     *
     * @apiSuccess {Integer} id SupportAvatar's id.
     * @apiSuccess {Integer} userId SupportAvatar's user id.
     * @apiSuccess {String} filename SupportAvatar's filename.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "userId": 1,
     *          "filename": "my_avatar_001.jpg"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} support/avatar/:id Delete supportAvatar object
     * @apiVersion 1.0.0
     * @apiName DeleteSupportAvatar
     * @apiGroup SupportAvatar
     *
     * @apiDescription Delete object of supportAvatar.
     *
     * @apiParam {Integer} id Identifier of supportAvatar object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $actions = [
            'user-avatar' => [
                'class' => UserAvatarAction::class,
                'modelClass' => new $this->modelClass(),
            ],
        ];
        return ArrayHelper::merge(parent::actions(), $actions);
    }
}
