<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 11:27
 */
declare(strict_types=1);

namespace App\Commands;

use App\Components\Amqp\AmqpRPCServer;
use yii\console\Controller;

/**
 * {@inheritDoc}
 */
class AmqpRpcServerController extends Controller
{

	/**
	 *
	 */
	public function actionRun(): void {

		$config = include APP_ROOT . 'config/common/amqp.php';
		$config['class'] = AmqpRPCServer::class;
		$modules = $this->getModulesList();
		/** @var AmqpRPCServer $obj */
		$obj = \Yii::createObject($config);
		$obj->registerComponents($modules);
		$obj->registerPCNTLSignals();
		$obj->listen();
	}

	/**
	 * @return array
	 */
	private function getModulesList(): array {
		$modulesList = [];
		foreach (\Yii::$app->modules as $key => $item) {
			if (is_array($item) && isset($item['class'])) {
				$class = $item['class'];
			} else {
				$class = $item;
			}

			$namespaces = $class::className();
			$testClass = new \ReflectionClass($namespaces);
			if ($testClass->hasConstant('AMQP_RPC_CLASS')) {
				\Yii::trace('Register module:' . $key);
				$modulesList[] = $class::AMQP_RPC_CLASS;
			}
		}
		return $modulesList;
	}
}