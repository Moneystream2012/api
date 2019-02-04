<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 28.07.17
 * Time: 16:39
 */
/**
 * @author Tarasenko Andrii
 * @date: 29.08.17
 */

namespace App\Modules\User\Modules\JWT;

use App\Helpers\Arr;
use App\Modules\User\Components\AppIdentityInterface;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Models\User;
use Yii;
use yii\base\ErrorException;
use yii\helpers\Json;
use yii\web\UnauthorizedHttpException;

/**
 * Class JWTIdentity
 * @package App\Modules\User\Modules\JWT
 */
class JWTIdentity implements AppIdentitzyInterface
{

    /**
     *
     */
    public const SESSION_LIFETIME = 900;

    /**
     * @var \App\Modules\User\Models\User
     */
    private $userModel;

    /**
     * @var string $address
     */
    private $address;

	/**
	 * @var
	 */
    private $tokenId;

	/**
	 * JWTIdentity constructor.
	 * @param int $userId
	 * @param string $tokenId
	 */
    public function __construct(int $userId, string $tokenId) {
    	$this->tokenId = $tokenId;
        $this->userModel = UserModelFactory::getClass(UserModelFactory::USER)
            ::find()
            ->where(['id' => $userId])
            ->one();
    }

    /**
     * @param $id
     * @return JWTIdentity
     */
    public static function findIdentity($id): JWTIdentity {
        return new self($id);
    }


    /**
     * @param mixed $token
     * @param null $type
     * @return bool|static
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        try {
            $res = (array)static::getCryptor()->decode($token);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            throw new UnauthorizedHttpException('Bad token');
        }

        if (!$res) {
	        Yii::trace('Can not decrypt token');
            return false;
        }
        if (!static::validateAuth($res, $token)) {
	        Yii::trace('Can not validate token');
            return false;
        }

	    static::updateToken($res);

        $identity = new static($res['userId'], $res['id']);
        $identity->setAddress($res['address']);

        return $identity;
    }

	/***
	 * @param array $res
	 * @param $token
	 * @return bool
	 * @throws UnauthorizedHttpException
	 */
    private static function validateAuth(array $res, $token): bool {
        $requiredData = [
	        'id',
            'userId',
            'address',
            'ip',
            'userAgent',
            'sessionTime',
            'dateCreated',
            'dateClosed',
        ];
        if (!Arr::keysExsists($res, $requiredData)) {
            throw new UnauthorizedHttpException('Wrong keys');
        }
	    if (Yii::$app->request->getUserIP() !== $res['ip']) {
		    return false;
	    }

	    if (Yii::$app->request->getUserAgent() !== $res['userAgent']) {
		    return false;
	    }

	    if ($res['dateClosed'] <= time()) {
		    return false;
	    }

	    if (\Yii::$app->redis->exists('user.sessions.' . $res['userId'].'.'.$res['id'])) {
		    \Yii::$app->redis->expire('user.sessions.' . $res['userId'].'.'.$res['id'], $res['dateClosed']);
		    \Yii::trace('Update token to this user:'.$res['userId']);
	    } else {
		    Yii::trace('Not found token in this user');
        	return false;
	    }

	    return true;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void {
        $this->address = $address;
    }

    /**
     * @param array $data
     */
    private static function updateToken(array $data) {
        $data['dateClosed'] = time() + self::SESSION_LIFETIME;
        $accessToken = self::getCryptor()->encode($data);
        Yii::$app->response->headers
            ->set('access-token', $accessToken)
            ->set('userId', $data['userId'])
            ->set('token-type', 'Bearer JWT');
    }


    /**
     * @return int
     */
    public function getId(): int {
        return $this->userModel->id;
    }

    /**
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }


    /**
     * @return ErrorException
     * @throws ErrorException
     */
    public function getAuthKey(): ErrorException {
        throw new ErrorException('Not implemented JWTIdentity->getAuthKey');
    }


    /**
     * @param string $authKey
     * @return ErrorException
     * @throws ErrorException
     */
    public function validateAuthKey($authKey): ErrorException {
        throw new ErrorException('Not implemented JWTIdentity->validateAuthKey');
    }

    /**
     * @var JWTCrypror
     */
    private static $cryptor = null;

    /**
     * @return JWTCrypror|object
     */
    public static function getCryptor() {
        if (self::$cryptor === null) {
	        $config = require ('Config/JWT.php');
            self::$cryptor = Yii::createObject($config);
        }

        return self::$cryptor;
    }

	/**
	 * @param int $userId
	 * @param string $address
	 * @param array $permissionList
	 * @return JWTIdentity
	 */
	public static function createSession(int $userId, string $address, $permissionList = []): JWTIdentity {
		$data = [
			'id'          => Yii::$app->security->generateRandomString(),
			'userId'      => $userId,
			'address'     => $address,
			'ip'          => Yii::$app->request->getUserIP(),
			'userAgent'   => Yii::$app->request->getUserAgent(),
			'sessionTime' => self::SESSION_LIFETIME,
			'dateCreated' => time(),
			'dateClosed'  => time() + self::SESSION_LIFETIME,
		];
		$accessToken = self::getCryptor()->encode($data);
		Yii::$app->response->headers
			->set('access-token', $accessToken)
			->set('userId', $userId)
			->set('token-type', 'Bearer JWT');
		$identity = new self($userId, $data['id']);
		$identity->setAddress($address);

		if (\Yii::$app->redis->exists('user.sessions.' . $userId.'.'.$data['id'])) {
			\Yii::trace('Update token to this user:'.$data['id']);
			\Yii::$app->redis->expire('user.sessions.' . $userId.'.'.$data['id'], $data['dateClosed']);
		} else {
			\Yii::trace('Add token to this user:'.$data['id']);
			\Yii::$app->redis->set('user.sessions.' . $userId . '.' . $data['id'], true);
			\Yii::$app->redis->expire('user.sessions.' . $userId . '.' . $data['id'], self::SESSION_LIFETIME);
		}

		return $identity;
	}

    /**
     * @return array
     */
    public function getUserInfo(): array {
        /** @var \App\Modules\User\Models\UserAuthAccess $authData */
        $authData = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS)
            ::find()
            ->with('user')
            ->where(['userId' => $this->getId()])
            ->one();

        return [
            'status' => 'ok',
            'data'   => array_merge([
                'id'         => $this->getId(),
                'address'    => $authData->address,

                'permission' => []
            ], $authData->user->getDataForAuth())
        ];
    }

	public function getUserModel(): User {
		return $this->userModel;
	}

	/**
	 * @return bool
	 */
	public function destroySession():bool {
		if (\Yii::$app->redis->exists('user.sessions.' . $this->getId().'.'.$this->tokenId)) {
			Yii::trace('Delete key '.$this->tokenId.' from user');
			return \Yii::$app->redis->del('user.sessions.' . $this->getId().'.'.$this->tokenId);
		} else {
			Yii::trace('Token not found');
			return false;
		}
	}
}
