<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 18.08.17
 * Time: 10:42
 */
declare(strict_types=1);

namespace tests\_support;

/**
 * Class RestCest
 * @package tests\_support
 */
/**
 * Class RestCest
 * @package tests\_support
 */
trait RestCest
{

	use AuthCest;

	/**
	 * @param $I
	 * @param $username
	 * @param $id
	 */
	public function setUser($I, $username, $id): void {

	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function testCreate(\FunctionalTester $I) {
		if (method_exists($this, 'create')) {
			$actionData = $this->create();

			if (isset($actionData['user'])) {
				$this->setUser($I, $actionData['user']);
			}

			$this->sendCreateRequest($I, $actionData);
			$I->canSeeResponseIsJson();
			$I->canSeeResponseCodeIs(201);
			$I->canSeeResponseContainsJson($actionData['expected']);

			if (isset($actionData['badUser'])) {
				$this->setUser($I, $actionData['badUser']);
				$this->sendCreateRequest($I, $actionData);
				$I->canSeeResponseCodeIs(403);
			}
		}
	}

	protected function sendCreateRequest(\FunctionalTester $I, array $actionData)
	{
		$I->sendPOST(\Yii::$app->getUrlManager()->createUrl($this->url), $actionData['data']);
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function testDelete(\FunctionalTester $I) {
		if (method_exists($this, 'delete')) {
			$actionData = $this->delete();

			if (isset($actionData['user'])) {
				$this->setUser($I, $actionData['user']);
			}

			$this->sendDeleteRequest($I, $actionData);
			$I->canSeeResponseCodeIs(204);
			$I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url . '/' . $actionData['data']));
			$I->canSeeResponseCodeIs(404);

			if (isset($actionData['badUser'])) {
				$this->setUser($I, $actionData['badUser']);
				$this->sendDeleteRequest($I, $actionData);
				$I->canSeeResponseCodeIs(403);
			}
		}
	}

	private function sendDeleteRequest(\FunctionalTester $I, array $actionData)
	{
		$I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url.'/'.$actionData['data']));
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function testGetList(\FunctionalTester $I) {
		if (method_exists($this, 'getList')) {
			$actionData = $this->getList();

			if (isset($actionData['user'])) {
				$this->setUser($I, $actionData['user']);
			}

			$this->sendListRequest($I, $actionData);
			$I->canSeeResponseCodeIs(200);
			$I->canSeeResponseContainsJson($actionData['expected']);

			if (isset($actionData['badUser'])) {
				$this->setUser($I, $actionData['badUser']);
				$this->sendListRequest($I, $actionData);
				$I->canSeeResponseCodeIs(403);
			}
		}
	}

	protected function sendListRequest(\FunctionalTester $I, array $actionData)
	{
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url));
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function testPut(\FunctionalTester $I): void {
		if (method_exists($this, 'put')) {
			$actionData = $this->put();

			if (isset($actionData['user'])) {
				$this->setUser($I, $actionData['user']);
			}

			$this->sendPut($I, $actionData);
			$I->canSeeResponseCodeIs(200);
			$I->canSeeResponseContainsJson($actionData['expected']);

			if (isset($actionData['badUser'])) {
				$this->setUser($I, $actionData['badUser']);
				$this->sendPut($I, $actionData);
				$I->canSeeResponseCodeIs(403);
			}
		}
	}

	protected function sendPut(\FunctionalTester $I, array $actionData)
	{
		$I->sendPUT(\Yii::$app->getUrlManager()->createUrl($this->url . '/' . $actionData['id']), $actionData['data']);
	}



	/**
	 * @param \FunctionalTester $I
	 */
	public function testGetById(\FunctionalTester $I) {
		if (method_exists($this, 'getById')) {
			$actionData = $this->getById();

			if (isset($actionData['user'])) {
				$this->setUser($I, $actionData['user']);
			}

			$this->sendGetRequest($I, $actionData);
			$I->canSeeResponseCodeIs(200);
			$I->canSeeResponseContainsJson($actionData['expected']);

			if (isset($actionData['badUser'])) {
				$this->setUser($I, $actionData['badUser']);
				$this->sendGetRequest($I, $actionData);
				$I->canSeeResponseCodeIs(403);
			}
		}
	}

	private function sendGetRequest(\FunctionalTester $I, array $actionData)
	{
		$I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url . '/'.$actionData['data']));
	}

}