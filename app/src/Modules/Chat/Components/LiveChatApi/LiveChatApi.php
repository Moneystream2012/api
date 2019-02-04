<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 18:55
 */

namespace App\Modules\Chat\Components\LiveChatApi;

use yii\base\Component;

class LiveChatApi extends Component
{
    public $login;
    public $apiKey;
    public $license;

    private $client;


    public function init(): void
    {
        $this->client = new \App\Modules\Chat\Components\LiveChatApi\Client($this->login, $this->apiKey, $this->license);

    }

    public function getClient()
    {
        return $this->client;
    }
}
