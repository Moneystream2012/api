<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 20:13
 */
declare(strict_types=1);

namespace App\Modules\Chat\Components\LiveChatApi\Model;


class BaseModel extends \LiveChat\Api\Model\BaseModel
{
    private $username = null;
    private $password = null;
    private $returnResponse = true;
    private $proxy = null;
    protected $license = null;

    public function __construct($username = null, $password = null, $returnResponse = true, $proxy = null, $license)
    {
        $this->username = $username;
        $this->password = $password;
        $this->returnResponse = (boolean) $returnResponse;
        $this->proxy = $proxy;
        $this->license = $license;

        parent::__construct($username, $password, $returnResponse, $proxy);
    }
}
