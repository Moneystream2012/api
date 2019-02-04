<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 25.09.17
 * Time: 12:44
 */

namespace App\Components;

use Mailgun\Mailgun;
use yii\base\Component;

/**
 * Class MailgunClient
 * @package App\Components
 */
class MailgunClient extends Component
{
    /**
     * @var
     */
    public $apiKey;

    /**
     * @var
     */
    private $client;

    /**
     *
     */
    public function init() : void
    {
        $this->client = Mailgun::create($this->apiKey);
    }

    /**
     * @param $domain
     * @param $params
     */
    public function send($domain, $params)
    {
        $this->client->messages()->send($domain, $params);
    }
}
