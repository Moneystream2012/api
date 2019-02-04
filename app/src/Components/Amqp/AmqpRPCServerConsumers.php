<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 28.08.17
 * Time: 12:48
 */
declare(strict_types=1);

namespace App\Components\Amqp;
use PhpAmqpLib\Message\AMQPMessage;
use yii\base\Component;

/**
 * Class AmqpRPCServerConsumers
 * @package App\Components\Amqp
 */
class AmqpRPCServerConsumers extends Component
{

	/**
	 * @var \PhpAmqpLib\Channel\AMQPChannel
	 */
	public $channel;

	/**
	 * @throws \Exception
	 */
	public function init() {
		if(null === $this->channel) {
			throw new \Exception('Params chanel must be set');
		}
	}

	public function register(): void {

		\Yii::trace('Init Declaration queue');

		$allMethods = get_class_methods(static::class);
		$serviceMethods = get_class_methods(self::class);

		foreach ($allMethods as $key => $item) {
			if(in_array($item, $serviceMethods, true)){
				unset($allMethods[$key]);
			}
		}
		$this->channel->basic_qos(
			null, #prefetch size - prefetch window size in octets, null meaning "no specific limit"
			1, #prefetch count - prefetch window in terms of whole messages
			null #global - global=null to mean that the QoS settings should apply per-consumer, global=true to mean that the QoS settings should apply per-channel
		);


		foreach ($allMethods as $item) {
			$this->channel->queue_declare(
				static::class.'::'.$item, #queue - Queue names may be up to 255 bytes of UTF-8 characters
				false, #passive - can use this to check whether an exchange exists without modifying the server state
				false, #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
				false, #exclusive - used by only one connection and the queue will be deleted when that connection closes
				false #auto delete - queue is deleted when last consumer unsubscribes
			);
			$this->channel->basic_consume(
				static::class.'::'.$item, #queue
				'', #consumer tag - Identifier for the consumer, valid within the current channel. just string
				false, #no local - TRUE: the server will not send messages to the connection that published them
				false, #no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
				false, #exclusive - queues may only be accessed by the current connection
				false, #no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
				[$this, 'callback']
			);
			\Yii::trace('Declareted: '.static::class.'::'.$item);
		}
	}

	/**
	 * @param AMQPMessage $req
	 */
	public function callback(AMQPMessage $req): void {
		\Yii::trace('Request  -> ' . $req->delivery_info['routing_key']);
		$res = explode('::', $req->delivery_info['routing_key']);

		if(!isset($res[0], $res[1])) {
			\Yii::error('Error to parse route: ' . $req->delivery_info['routing_key']);
		}

		$body = unserialize($req->body, ['allowed_classes' => true]);

		$res = call_user_func_array([$this, $res[1]], $body);
		$msg = new AMQPMessage(
			serialize($res),
			['correlation_id' => $req->get('correlation_id')]
		);
		\Yii::trace('Response <- ' . $req->delivery_info['routing_key']);
		$req->delivery_info['channel']->basic_publish(
			$msg, '', $req->get('reply_to'));
		$req->delivery_info['channel']->basic_ack(
			$req->delivery_info['delivery_tag']);
	}
}