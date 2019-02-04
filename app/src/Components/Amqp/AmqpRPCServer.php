<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 28.08.17
 * Time: 12:48
 */
declare(strict_types=1);

namespace App\Components\Amqp;

use PhpAmqpLib\Exception\AMQPRuntimeException;

/**
 * Class rpcServer
 */
class AmqpRPCServer extends AmqpConnection
{
	/**
	 * @var \PhpAmqpLib\Channel\AMQPChannel
	 */
	protected $channel;

	/**
	 * @var string
	 * @throws \Exception
	 */

	public function init()
	{
		parent::init();
		$this->channel = $this->connection->channel();
	}

	public function registerComponents(array $modulesList = []): void {
		\Yii::info('Register Components: ' . count($modulesList));
		foreach ($modulesList as $item) {
			/** @var AmqpRPCServerConsumers $obj */
			$obj = new $item(['channel' => $this->channel]);
			$obj->register();
		}


	}

	public function registerPCNTLSignals(): void {
		define('AMQP_WITHOUT_SIGNALS', false);
		declare(ticks = 1) {
			pcntl_signal(\SIGTERM, [$this, 'kill']);
			pcntl_signal(\SIGINT,  [$this, 'kill']);
			pcntl_signal(\SIGUSR1, [$this, 'kill']);
			pcntl_signal(\SIGHUP,  [$this, 'kill']);
		}
		\Yii::trace('Register PCNTL handler for SIGTERM,SIGINT,SIGUSR1,SIGHUP');
	}

	public function kill($sign): void {
		\Yii::info('Handle '.$sign.' PCNTL signal. System shutdown');
		$this->channel->close();
		$this->connection->close();
	}

	/**
	 *
	 */
	public function listen(): void {
		\Yii::info('Awaiting RPC requests');
		try {
			while (count($this->channel->callbacks)) {
				$this->channel->wait();
			}
		} catch (AMQPRuntimeException $e) {
			\Yii::error($e->getMessage());
		}

	}
}