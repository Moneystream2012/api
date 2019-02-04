<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 19:08
 */

namespace App\Modules\Chat\Components\LiveChatApi;



class Client extends \LiveChat\Api\Client
{
    /**
     * @inheritdoc
     */
    private $apiLogin = null;

    /**
     * @inheritdoc
     */
    private $apiKey = null;

    /**
     * @inheritdoc
     */
    private $returnResponse = true;

    /**
     * @inheritdoc
     */
    private $proxy = null;

    private $license = null;

    public function __construct($login = null, $apiKey = null, $license)
    {
        $this->apiLogin = $login;
        $this->apiKey = $apiKey;
        $this->license = $license;

        parent::__construct($login, $apiKey);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        $namespaces = [
            'LiveChat\Api\Model\\',
            'App\Modules\Chat\Components\LiveChatApi\Model\\'
        ];

        foreach ($namespaces as $namespace) {
            $className = $namespace . ucfirst($name);
            if (class_exists($className)) {
                return new $className($this->apiLogin, $this->apiKey, $this->returnResponse, $this->proxy, $this->license);
            }
        }

        throw new \Exception('No such model: '.$name);
    }
}
