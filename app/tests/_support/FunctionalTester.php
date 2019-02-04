<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;
    use \tests\_support\AuthCest;

	/**
	 * @param $url
	 * @param null $params
	 * @param array $files
	 * @return mixed|null
	 */
	public function sendPOSTInternal($url, $params = null, $files = []) {
	    return $this->getScenario()->runStep(new \Codeception\Step\Action('sendPOST', [
		    \Yii::$app->getUrlManager()->createUrl($url),
		    $params,
		    $files
	    ]));
	}


	public function sendGETInternal($url, $params = []) {
		return $this->getScenario()->runStep(new \Codeception\Step\Action('sendGET', [
			\Yii::$app->getUrlManager()->createUrl($url),
			$params
		]));
	}

	/**
	 *
	 */
	public function am($role): void {
		$this->setUserByRole($role);
	}
}
