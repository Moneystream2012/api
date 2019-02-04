<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\User\Controllers;

use App\{
	Components\RestController,
	Modules\User\Components\UserModelFactory,
    Helpers\Arr
};
use yii\filters\AccessControl;

/**
 * Class UserController
 * @package App\Modules\User\Controllers
 */
class UserController extends RestController
{
	public $modelClass;

	/**
	 * Init model class
	 */
	public function init(): void
	{
		$this->modelClass = UserModelFactory::getClass(UserModelFactory::USER);
	}

    /**
     * Behaviors
     *
     * @return array
     */
	public function behaviors(): array {
        $behaviors = parent::behaviors();

        $behaviors['access']  = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
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
	protected function verbs(): array {
		return [
			'index' => ['GET'],
		];
	}

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return Arr::removeSeveral(parent::actions(), ['view', 'create', 'update', 'delete']);
    }

	/**
	 * @api {post} /user Create user
	 * @apiVersion 1.0.0
	 * @apiName CreateUser
	 * @apiGroup User
	 *
	 * @apiDescription Create new user object.
	 *
	 * @apiParam {String} username User's name.
	 * @apiParam {Boolean} [active=true] User activation status.
	 * @apiParam {Boolean} [notification=false] Status of notification receive settings.
	 * @apiParam {String} [email] User's email address.
	 * @apiParam {String} [phone] User's phone number.
	 * @apiParam {String} [country_code] User's country code.
	 *
	 * @apiSuccess {Integer} id User's id.
	 * @apiSuccess {String} username User's name.
	 * @apiSuccess {Boolean} active User activation status.
	 * @apiSuccess {Boolean} notification Status of notification receive settings.
	 * @apiSuccess {String} email User's email address.
	 * @apiSuccess {String} phone User's phone number.
	 * @apiSuccess {String} country_code User's country code.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *          "id": 1,
	 *          "username": "Vasya",
	 *          "active": true,
	 *          "notification": false,
	 *          "email": "mail@domain.com",
	 *          "phone": 380000000000,
	 *          "country_code": "UA"
	 *     }
	 *
	 * @apiUse NotFoundError
	 * @apiUse UnauthorisedError
	 * @apiUse UnvalidatedError
	 * @apiUse UnavailableError
	 */

	/**
	 * @api {get} /user Get list of users
	 * @apiVersion 1.0.0
	 * @apiName GetUsers
	 * @apiGroup User
	 *
	 * @apiDescription Get list of users.
	 *
	 * @apiSuccess {Array} Response List of Object(s).
	 * @apiSuccess {Integer} Object.id User's id.
	 * @apiSuccess {String} Object.username User's name.
	 * @apiSuccess {Boolean} Object.active User activation status.
	 * @apiSuccess {Boolean} Object.notification Status of notification receive settings.
	 * @apiSuccess {String} Object.email User's email address.
	 * @apiSuccess {String} Object.phone User's phone number.
	 * @apiSuccess {String} Object.country_code User's country code.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     [
	 *          {
	 *              "id": 1,
	 *              "username": "Vasya",
	 *              "active": true,
	 *              "notification": false,
	 *              "email": "mail@domain.com",
	 *              "phone": 380000000000,
	 *              "country_code": "UA"
	 *          }
	 *     }
	 *
	 * @apiUse UnauthorisedError
	 * @apiUse UnavailableError
	 */

	/**
	 * @api {get} /user/:id Get user object
	 * @apiVersion 1.0.0
	 * @apiName GetUser
	 * @apiGroup User
	 *
	 * @apiDescription Get object of user.
	 *
	 * @apiParam {Integer} id Identifier of user object.
	 *
	 * @apiSuccess {Integer} id User's id.
	 * @apiSuccess {String} username User's name.
	 * @apiSuccess {Boolean} active User activation status.
	 * @apiSuccess {Boolean} notification Status of notification receive settings.
	 * @apiSuccess {String} email User's email address.
	 * @apiSuccess {String} phone User's phone number.
	 * @apiSuccess {String} country_code User's country code.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *          "id": 1,
	 *          "username": "Vasya",
	 *          "active": true,
	 *          "notification": false,
	 *          "email": "mail@domain.com",
	 *          "phone": 380000000000,
	 *          "country_code": "UA"
	 *     }
	 *
	 * @apiUse NotFoundError
	 * @apiUse UnavailableError
	 */

	/**
	 * @api {put} /user/:id Update user object
	 * @apiVersion 1.0.0
	 * @apiName UpdateUser
	 * @apiGroup User
	 *
	 * @apiDescription Update object of user.
	 *
	 * @apiParam {String} username User's name.
	 * @apiParam {Boolean} [active=true] User activation status.
	 * @apiParam {Boolean} [notification=false] Status of notification receive settings.
	 * @apiParam {String} [email] User's email address.
	 * @apiParam {String} [phone] User's phone number.
	 * @apiParam {String} [country_code] User's country code.
	 *
	 * @apiSuccess {Integer} id User's id.
	 * @apiSuccess {String} username User's name.
	 * @apiSuccess {Boolean} active User activation status.
	 * @apiSuccess {Boolean} notification Status of notification receive settings.
	 * @apiSuccess {String} email User's email address.
	 * @apiSuccess {String} phone User's phone number.
	 * @apiSuccess {String} country_code User's country code.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *          "id": 1,
	 *          "username": "Vasya",
	 *          "active": true,
	 *          "notification": false,
	 *          "email": "mail@domain.com",
	 *          "phone": 380000000000,
	 *          "country_code": "UA"
	 *     }
	 *
	 * @apiUse NotFoundError
	 * @apiUse UnauthorisedError
	 * @apiUse UnvalidatedError
	 * @apiUse UnavailableError
	 */

	/**
	 * @api {delete} /user/:id Delete user object
	 * @apiVersion 1.0.0
	 * @apiName DeleteUser
	 * @apiGroup User
	 *
	 * @apiDescription Delete object of user.
	 *
	 * @apiParam {Integer} id Identifier of user object.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 204 No content
	 *
	 * @apiUse NotFoundError
     * @apiUse UnauthorisedError
	 * @apiUse UnavailableError
	 */
}
