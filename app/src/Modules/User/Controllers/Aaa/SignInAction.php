<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use App\Components\BaseAction;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Modules\JWT\JWTIdentity;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * Class SignInAction
 * @package App\Modules\User\Controllers\AAA
 */
class SignInAction extends BaseAction
{

    /**
     * @var SignInModel
     */
    public $modelClass = null;

	/**
	 * @throws UserException
	 */
    public function run() {

        /** @var \App\Modules\User\Models\UserAuthAccess $user */
        $user = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS)
            ::find()
            ->where(['address' => $this->modelClass->address])
            ->one();

        if (empty($user)) {
            $this->modelClass->addError('address', 'Not found user with received credentials.');
            return $this->modelClass;
        }

        try {

            if ($user->needChange()) {
                if (sha1(md5($this->modelClass->password)) != $user->old_password) {
                    $this->modelClass->addError('address', 'Not found user with received credentials.');
                    return $this->modelClass;
                }

                $user->password = \Yii::$app->security->generatePasswordHash($this->modelClass->password);
                $user->is_password_changed = 1;

                if (!$user->save()) {
                    $this->modelClass->addError('address', 'Server error. Please try later.');
                    return $this->modelClass;
                }

            } elseif (!\Yii::$app->security->validatePassword($this->modelClass->password, $user->password)) {
                $this->modelClass->addError('address', 'Not found user with received credentials.');
                return $this->modelClass;
            }

        } catch (InvalidParamException $exception) {
            $this->modelClass->addError('passwordRecovery', ' Password recovery required');
            return $this->modelClass;
        }

	    $identity = JWTIdentity::createSession($user->userId, $user->address, []);

	    \Yii::$app->user->login($identity);
        \Yii::$app->user->sendUserData();
    }
}