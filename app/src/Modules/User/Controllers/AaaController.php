<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);


namespace App\Modules\User\Controllers;

use App\Components\RestController;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Components\UserModelValidateFactory;
use App\Modules\User\Controllers\Aaa\ChangePasswordAction;
use App\Modules\User\Controllers\Aaa\PasswordRecoveryAction;
use App\Modules\User\Controllers\Aaa\SignOutAction;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;

/**
 * Class AAAController
 * @package App\Modules\User\Controllers
 */
class AaaController extends RestController
{
    public function beforeAction($action) {
        if (\Yii::$app->request->getIsOptions() and $this->action->id !== 'options') {
            $this->runAction('options');
            return false;
        } else {
            return parent::beforeAction($action);
        }
    }

    /**
     * @var bool
     */
    public $modelClass = false;
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'sign-in'        => [
                'class' => Aaa\SignInAction::class,
                'modelClass' => UserModelValidateFactory::getClass(UserModelValidateFactory::AAA_SIGN_IN)
            ],
            'validate-token' => Aaa\ValidateTokenAction::class,
            'register'       => [
                'class' => Aaa\RegisterAction::class,
                'modelClass' => UserModelValidateFactory::getClass(UserModelValidateFactory::AAA_REGISTER)
            ],
            'verify'       => [
                'class' => Aaa\VerifyAction::class,
                'modelClass' => UserModelValidateFactory::getClass(UserModelValidateFactory::AAA_REGISTER)
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
            'sign-out' => [
                'class' => SignOutAction::class,
                'modelClass' => ''
            ],
            'change-password' => [
                'class' => ChangePasswordAction::class,
                'modelClass' => UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS)
            ],
            'password-recovery' => [
                'class' => PasswordRecoveryAction::class,
                'modelClass' => UserModelValidateFactory::getClass(UserModelValidateFactory::PASSWORD_RECOVERY)
            ],
        ];
    }

	/**
	 * @return array
	 */
	public function behaviors() :array {
		$behaviors = parent::behaviors();
		$behaviors = \yii\helpers\ArrayHelper::merge($behaviors, [
			'authenticator' => [
				'class' => CompositeAuth::class,
				'except' => ['options', 'sign-in', 'register', 'verify', 'password-recovery'],
				'authMethods' => [
					\App\Modules\User\Modules\JWT\JWTBehavior::class,
					\App\Modules\User\Components\NoneAuth::class
				]
			]
		]);

        $behaviors['access']  = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['sign-in', 'register', 'verify', 'password-recovery'],
                ],
                [
                    'allow' => true,
                    'actions' => ['validate-token', 'sign-out', 'change-password'],
                    'roles' => ['user'],
                ],
            ],
        ];

		return $behaviors;
	}

    protected function verbs()
    {
        $verbs = parent::verbs();

        return ArrayHelper::merge($verbs, [
            'sign-in'        => ['POST'],
            'validate-token' => ['POST'],
            'register'       => ['POST'],
            'verify'       => ['POST'],
            'sign-out'       => ['POST'],
            'change-password' => ['POST'],
            'password-recovery'       => ['POST'],
        ]);
    }


	/**
     * @api {get} aaa/register
     * @apiVersion 1.0.0
     * @apiName register
     * @apiGroup User
     *
     * @apiDescription Register new user into system.
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

}