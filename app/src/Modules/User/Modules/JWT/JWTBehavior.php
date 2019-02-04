<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 28.07.17
 * Time: 16:39
 */

namespace App\Modules\User\Modules\JWT;

use App\Modules\User\Components\JWT;
use Yii;
use yii\web\User;
use yii\web\Request;
use yii\web\Response;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

/**
 * Class JWTBehavior
 * @package App\Modules\User\Modules\JWT
 */
class JWTBehavior extends AuthMethod
{

	private const HEADER = 'Bearer JWT';

    /**
     * Authenticates the current user.
     * @param \User $user
     * @param Request $request
     * @param Response $response
     * @return \yii\web\IdentityInterface the authenticated user identity.
     * If authentication information is not provided, null will be returned.
     * @throws UnauthorizedHttpException if authentication information is provided but is invalid.
     */
    public function authenticate($user, $request, $response): ?\yii\web\IdentityInterface {

        Yii::trace('Authenticate BearerAuth', __CLASS__);
        if ($request->getHeaders()->get('token-type', false) == self::HEADER) {
            return $this->authBearer($user, $request, $response);
        } else {
            return null;
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @param Response $response
     * @return bool|\yii\web\IdentityInterface
     */
    private function authBearer(User $user, Request $request, Response $response) {

        $accessToken = $request->getHeaders()->get('access-token', false);

        if ($accessToken === false) {
            Yii::error('accessToken not found in headers', 'BearerAuth');
	        return null;
        }


        $identityObject = JWTIdentity::findIdentityByAccessToken($accessToken);
        if ($identityObject !== false) {
            if (!$user->login($identityObject)) {
                Yii::error('Error update user in yii core', 'BearerAuth');
                return $this->handleFailure($response);
            }
        } else {
	        return $this->handleFailure($response);
        }

        return $identityObject;
    }

	/**
	 * @param Response $response
	 * @throws UnauthorizedHttpException
	 */
    public function handleFailure($response) {
        throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
    }
}
