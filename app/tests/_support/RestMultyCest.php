<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * Date: 18.08.17, 05.10.17
 */

declare(strict_types=1);

namespace tests\_support;

use \Codeception\Util\HttpCode;

/**
 * Class RestMultyCest
 * @package tests\_support
 */
trait RestMultyCest
{
	use RoleCest;

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	protected function testCreateSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);

        if (isset($role)) {
            $this->setUser($I, $role);

            $I->sendPOST(\Yii::$app->getUrlManager()->createUrl($this->url), $data);
            $I->canSeeResponseIsJson();
            $I->canSeeResponseCodeIs(HttpCode::CREATED);
            $I->canSeeResponseContainsJson($data);
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     * @param int $failCode
     */
    protected function testCreateFail(\FunctionalTester $I, \Codeception\Example $example, int $failCode = HttpCode::FORBIDDEN): void {

        list($data, $testRoles) = $this->getTestRoleData($example, $failCode);
        $testField = $this->getFirstKey($data);

        if (method_exists($this, 'createData')) {
            $data = array_merge($this->createData(), $data);
        }

        foreach ((array)$testRoles as $role) {
            $this->setUser($I, $role);

            $I->sendPOST(\Yii::$app->getUrlManager()->createUrl($this->url), $data);
            $I->canSeeResponseCodeIs($failCode);

            if (!in_array($failCode, [HttpCode::FORBIDDEN, HttpCode::NOT_FOUND]) && $testField) {
                $I->canSeeResponseContains($testField);
            }
        }
    }

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    protected function testDeleteSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);

        if (isset($role)) {
            $this->setUser($I, $role);

            $I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url .'/'. $data['id']));
            $I->canSeeResponseCodeIs(HttpCode::NO_CONTENT);
            $I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url .'/'. $data['id']));
            $I->canSeeResponseCodeIs(HttpCode::NOT_FOUND);
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     * @param int $failCode
     */
    protected function testDeleteFail(\FunctionalTester $I, \Codeception\Example $example, int $failCode = HttpCode::FORBIDDEN): void {

        list($data, $failRoles) = $this->getTestRoleData($example, $failCode);

        foreach ((array)$failRoles as $role) {
            $this->setUser($I, $role);

            $I->sendDELETE(\Yii::$app->getUrlManager()->createUrl($this->url .'/'. $data['id']));
            $I->canSeeResponseCodeIs($failCode);
        }
    }

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    protected function testGetListSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);

        if (isset($role)) {
            $this->setUser($I, $role);

            $I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url));
            $I->canSeeResponseCodeIs(HttpCode::OK);
            $I->canSeeResponseContainsJson($data["expected"]);
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     * @param int $failCode
     */
    protected function testGetListFail(\FunctionalTester $I, \Codeception\Example $example, int $failCode = HttpCode::FORBIDDEN): void {

        list(, $failRoles) = $this->getTestRoleData($example, $failCode);

        foreach ((array)$failRoles as $role) {
            $this->setUser($I, $role);

            $I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url));
            $I->canSeeResponseCodeIs($failCode);
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    protected function testPutSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);
        if (isset($role)) {
            $this->setUser($I, $role);

            $I->sendPUT(\Yii::$app->getUrlManager()->createUrl($this->url . '/' . $data['id']), $data['send']);
            $I->canSeeResponseCodeIs(HttpCode::OK);
	        $I->seeResponseIsJson();
            $I->canSeeResponseContainsJson($data['send']);
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     * @param int $failCode
     */
	protected function testPutFail(\FunctionalTester $I, \Codeception\Example $example, int $failCode = HttpCode::FORBIDDEN): void {

        list($data, $failRoles) = $this->getTestRoleData($example, $failCode);
        $testField = $this->getFirstKey($data['send']);

        if (method_exists($this, 'putData')) {
            $data = array_merge($this->putData(), $data);
        }

        foreach ((array)$failRoles as $role) {
            $this->setUser($I, $role);

            $I->sendPUT(\Yii::$app->getUrlManager()->createUrl($this->url . '/' . $data['id']), $data['send']);
            $I->canSeeResponseCodeIs($failCode);

            if (!in_array($failCode, [HttpCode::FORBIDDEN, HttpCode::NOT_FOUND])) {
	            $I->seeResponseIsJson();
                $I->canSeeResponseContains($this->getFirstKey($data['send']));
            }
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
    protected function testGetByIdSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

        list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);

        if (isset($role)) {
            $this->setUser($I, $role);

            $I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url . '/' . $data['id']));
            $I->canSeeResponseCodeIs(HttpCode::OK);
	        $I->seeResponseIsJson();
            $I->canSeeResponseContainsJson($data['expected']);
        }
	}

    /**
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     * @param int $failCode
     */
    protected function testGetByIdFail(\FunctionalTester $I, \Codeception\Example $example, int $failCode = HttpCode::FORBIDDEN): void {

        list($data, $failRoles) = $this->getTestRoleData($example, $failCode);

        foreach ((array)$failRoles as $role) {
            $this->setUser($I, $role);

            $I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url . '/' . $data['id']));
            $I->canSeeResponseCodeIs($failCode);
        }
	}

    /**
     * @param array $data
     *
     * @return null|string
     */
    protected function getFirstKey(array $data): ?string {
    	foreach ($data as $key => &$value) {
    		if (is_array($value)) {
			    $value = $key;
		    }
	    }

        $data = array_flip($data);
        return array_shift($data);
    }

	/**
	 * ACTION`s UNIFIED TEST`s
	 */

	/**
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example|array $example
	 */
	protected function testActionPositive(\FunctionalTester $I, $example): void {

		list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);
		$this->setUser($I, $role);

		$I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url . $data['url']));
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->seeResponseIsJson();

		if (isset($data['expected'])) {
			foreach ((array)$data['expected'] as $expected) {
				$I->seeResponseContainsJson($expected);
			}
		}

		if (isset($data['absent'])) {
			foreach ((array)$data['absent'] as $absent) {
				$I->dontSeeResponseContainsJson($absent);
			}
		}
	}

	/**
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 * @param int $failCode
	 */
	protected function testActionFail(\FunctionalTester $I, \Codeception\Example $example, int $failCode = HttpCode::FORBIDDEN): void {

		list($data, $failRoles) = $this->getTestRoleData($example, $failCode);

		foreach ($failRoles as $role) {
			$this->setUser($I, $role);

			$I->sendGET(\Yii::$app->getUrlManager()->createUrl($this->url . $data['url']));
			$I->seeResponseCodeIs($failCode);
		}
	}

	/**
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 * @param null|int $restrictCode
	 */
	protected function testRestrictedMethods(\FunctionalTester $I, \Codeception\Example $example, ?int $restrictCode = null): void {

		list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);
		$this->setUser($I, $role);

		$restrictedMethods = $this->getRestrictedMethods($data['allowed']);
		unset($data['allowed']);

		$urlId = '/'. (isset($data['id']) ? $data['id'] : 1);

		foreach ($restrictedMethods as $method) {
			$url = $this->url . $data['url'] . (in_array($method, ['PUT', 'DELETE']) ? $urlId : '');

			$this->sendRequest($I, \Yii::$app->getUrlManager()->createUrl($url), $method, []);

			if (isset($restrictCode)) {
				$I->seeResponseCodeIs($restrictCode);
			} else {
				$I->dontSeeResponseCodeIs(HttpCode::OK);
			}
		}
	}

	/**
	 * @param \FunctionalTester $I
	 * @param string $url
	 * @param string $method
	 * @param null|array $params
	 */
	protected function sendRequest(\FunctionalTester $I, string $url, string $method, $params = null): void {
		switch ($method) {
			case 'GET':
				$I->sendGET($url);
			break;

			case 'POST':
				$I->sendPOST($url, $params);
			break;

			case 'PUT':
				$I->sendPUT($url, $params);
			break;

			case 'DELETE':
				$I->sendDELETE($url);
			break;
		}
	}

	/**
	 * @param string|array $allowed
	 *
	 * @return array
	 */
	protected function getRestrictedMethods($allowed): array {

		$methods = ["GET", "POST", "PUT", "DELETE"];

		foreach ((array)$allowed as $method) {
			$index = array_search($method, $methods);
			if ($index !== false) {
				unset($methods[$index]);
			}
		}

		return $methods;
	}

	/**
	 *
	 */
	protected function setUser($i, $j = null, $k = null) {

	}
}