<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\User\Components;

use App\{
    Components\BaseModelFactory,
    Modules\User\Models\User,
    Modules\User\Models\UserAuthAccess,
    Modules\User\Models\UserSessions
};

/**
 * Class UserModelFactory
 * @package App\Modules\User\Components
 */
class UserModelFactory extends BaseModelFactory
{
    /**
     *
     */
    public const USER = 'user';

    /**
     *
     */
    public const USER_AUTH_ACCESS = 'user_auth_access';

    /**
     *
     */
    public const USER_SESSIONS = 'user_sessions';

	/**
	 * Method which populates @var $models
	 */
    protected static function populateModels() {
        static::$models = [
            static::USER             => User::class,
            static::USER_AUTH_ACCESS => UserAuthAccess::class,
            static::USER_SESSIONS    => UserSessions::class
        ];
    }
}