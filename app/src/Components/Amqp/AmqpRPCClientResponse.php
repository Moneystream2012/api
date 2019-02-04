<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 29.08.17
 * Time: 9:22
 */
declare(strict_types=1);

namespace App\Components\Amqp;

use PhpAmqpLib\Message\AMQPMessage;
use yii\base\Object;


/**
 * Class AmqpRPCClient
 * @package App\Components\Amqp
 */
class AmqpRPCClientResponse extends Object
{

	/**
	 * @var \PhpAmqpLib\Channel\AMQPChannel
	 */
	public $channel = false;

	/**
	 * @var bool
	 */
	private $isDone = false;

	/**
	 * @var string
	 */
	private $correlationId;

	/**
	 * @var mixed
	 */
	private $response = false;

	/**
	 * @throws \Exception
	 */
	public function init() {
		if($this->channel === false) {
			throw new \Exception('Parameter channel is not set');
		}
		$this->correlationId = sha1(time() . random_int(0, 1000000));
	}


	/**
	 * @return bool
	 */
	public function isDone() : bool {
		return $this->isDone;
	}

	/**
	 * @return mixed
	 */
	public function getContent(){
		return $this->response;
	}

	/**
	 * @param string $namespace
	 * @param string $methodName
	 * @param array $params
	 * @return string|mixed
	 */
	public function sendRequest(string $namespace, string $methodName, array $params) {
		list($callbackQueue, ,) = $this->channel->queue_declare('', false, false, true, false);

		$response = null;
		$this->channel->basic_consume(
			$callbackQueue,#queue
			'', #consumer tag - Identifier for the consumer, valid within the current channel. just string
			false,#no local - TRUE: the server will not send messages to the connection that published them
			false,#no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
			false,#exclusive - queues may only be accessed by the current connection
			false,#no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
			[$this, 'onResponse'] #callback
		);


		$this->response = null;
		$this->correlationId = sha1(time() . random_int(0, 1000000));
		$msg = new AMQPMessage(
			serialize($params),
			[
				'correlation_id' => $this->correlationId,
				'reply_to'       => $callbackQueue
			]
		);
		$this->channel->basic_publish($msg, '', $namespace . '::' . $methodName);
		return $this->correlationId;
	}

	public function onResponse(AMQPMessage $rep): void {
		if ($rep->get('correlation_id') === $this->correlationId) {
			$this->response = unserialize($rep->body, ['allowed_classes' => true]);
			$this->isDone = true;
			\Yii::trace('Find response by #' . $this->correlationId, 'Amqp-RPC-Client');
		}
	}

}