<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 07.08.17
 * Time: 16:36
 */

namespace App\Modules\User\Components;

use App\Components\BaseModelFactory;
use App\Modules\User\{
    Controllers\Aaa\PasswordRecoveryModel, Controllers\Aaa\RegisterModel, Controllers\Aaa\SignInModel
};

/**
 * Class UserModelValidateFactory
 * @package App\Modules\User\Components
 */
class UserModelValidateFactory extends BaseModelFactory
{
    /**
     *
     */
    public const AAA_REGISTER = 'aaa_register';

    /**
     *
     */
    public const AAA_SIGN_IN = 'aaa_sign_in';

    public const PASSWORD_RECOVERY = 'passwordRecovery';

    /**
     * Method which populates @var $models
     */
    protected static function populateModels() {
        static::$models = [
            static::AAA_REGISTER => RegisterModel::class,
            static::AAA_SIGN_IN  => SignInModel::class,
            static::PASSWORD_RECOVERY => PasswordRecoveryModel::class,
        ];
    }
}
