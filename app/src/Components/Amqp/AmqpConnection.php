<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 29.08.17
 * Time: 10:30
 */
declare(strict_types=1);

namespace App\Components\Amqp;

use yii\base\Component;


/**
 * Class AmqpConnection
 * @package App\Components\Amqp
 */
abstract class AmqpConnection extends Component
{
	/**
	 * @var \PhpAmqpLib\Connection\AMQPConnection
	 */
	protected $connection;
	/**
	/**
	 * @var string
	 */
	public $host = '127.0.0.1';
	/**
	 * @var integer
	 */
	public $port = 5672;
	/**
	 * @var string
	 */
	public $user;
	/**
	 * @var string
	 */
	public $password;
	/**
	 * @var string
	 */
	public $vhost = '/';

	/**
	 * @throws \Exception
	 */
	public function init()
	{
		parent::init();
		if (empty($this->user)) {
			throw new \Exception("Parameter 'user' was not set for AMQP connection.");
		}
		\Yii::trace('Connecting to AMQP buss', 'Amqp');
		$this->connection = new \PhpAmqpLib\Connection\AMQPConnection(
			$this->host,
			$this->port,
			$this->user,
			$this->password,
			$this->vhost
		);
	}

}