<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 28.07.17
 * Time: 17:48
 */

namespace App\Modules\User\Modules\JWT;

use yii\base\InvalidConfigException;
use yii\base\Object;
use \Firebase\JWT\JWT as JWTCore;

/**
 * Class JWT
 * @package Modules\User\Components
 */
class JWTCrypror extends Object
{

    /**
     * @var string Path to public key file
     */
    public $publicKey = null;

    /**
     * @var string Path to private key file
     */
    public $privateKey = null;

    /**
     * @var string
     */
    public $algorithm = 'RS256';

    /**
     *
     */
    public function init() {
        if ($this->privateKey == null) {
            throw new InvalidConfigException('JWT privateKey not set');
        }

        if ($this->publicKey == null) {
            throw new InvalidConfigException('JWT privateKey not set');
        }
        if (!isset(JWTCore::$supported_algs[$this->algorithm])) {
            throw new InvalidConfigException('Algorithm "' . $this->algorithm . '" not supported in JWT library');
        }
    }

    /**
     * @param $data
     * @param null $keyId
     * @param null $head
     * @return string
     */
    public function encode($data, $keyId = null, $head = null): string {
        return JWTCore::encode($data, file_get_contents($this->privateKey), $this->algorithm, $keyId, $head);
    }

	/**
	 * @param string $content
	 * @param array $allowedAlgs
	 * @return mixed
	 * @throws \UnexpectedValueException
	 * @throws \Firebase\JWT\SignatureInvalidException
	 * @throws \Firebase\JWT\ExpiredException
	 * @throws \Firebase\JWT\BeforeValidException
	 */
    public function decode(string $content, array $allowedAlgs = []) {
	    return JWTCore::decode(
	    	$content,
		    file_get_contents($this->publicKey),
		    $allowedAlgs ? $allowedAlgs : [$this->algorithm]
	    );
    }
}
