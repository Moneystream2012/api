<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 29.08.17
 * Time: 9:22
 */
declare(strict_types=1);

namespace App\Components\Amqp;

use App\Helpers\Arr;


/**
 * Class AmqpRPCClient
 * @package App\Components\Amqp
 */
class AmqpRPCClient extends AmqpConnection
{

	/**
	 * @var \PhpAmqpLib\Channel\AMQPChannel
	 */
	public $channel;

	public $timeout;

	/**
	 * @var array
	 */
	private static $queue = [];

	/**
	 *
	 */
	public function init() {
		parent::init();
		$this->channel = $this->connection->channel();
	}

	/**
	 * @param string $namespace
	 * @param string $methodName
	 * @param array $params
	 * @param bool $blocking
	 * @return mixed|string
	 */
	public function createRequest(string $namespace, string $methodName, array $params, bool $blocking = false) {
		$obj = new AmqpRPCClientResponse(['channel' => $this->channel]);
		$correlationId = $obj->sendRequest($namespace, $methodName, $params);
		\Yii::trace('Send request #' . $correlationId, 'Amqp-RPC-Client');
		self::$queue[$correlationId] = $obj;
		if($blocking) {
			$result = $this->wait([$correlationId], $blocking);
			return Arr::getValue($result, $correlationId, false);
		}
		return $correlationId;
	}

	/**
	 * @param array $correlationIds
	 * @return array
	 */
	public function wait(array $correlationIds): array {
		\Yii::trace('Wait PRC response form '.count($correlationIds).' requests', 'Amqp-RPC-Client');
		$response = [];
		while (count($correlationIds) !== count($response)) {
			$this->channel->wait(null, false, $this->timeout);
			foreach (self::$queue as $k => $item) {
				if($item->isDone()) {
					$response[$k] = $item->getContent();
					unset(self::$queue[$k]);
				}
			}
		}

		return $response;
	}


}