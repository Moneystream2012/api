<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 25.10.17
 * Time: 18:47
 */




/**
 * @example{"role":"admin", "id":"1"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
/*public function deleteRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testDeleteFail($I, $example, HttpCode::NOT_FOUND);
}*/

/**
 * @example{"role":"admin", "expected":[{"id":"1","userId": "1", "typeId":"1", "amount":"29.25087515", "rate":"0.07", "status": "pending", "createdAt":"2017-08-24 11:37:15"}]}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function getSuccess(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testGetListSuccess($I, $example);
}

/**
 * @example{"role":"admin"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function getListRoleFail(\FunctionalTester $I, \Codeception\Example $example): void {

	//TODO $this->testGetListFail($I, $example, HttpCode::FORBIDDEN);
}

/**
 * @example{"role":"admin", "id":"1", "send":{"userId": "1", "typeId":"1", "amount":"29.25087515", "rate":"0.07", "status": "active"}}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function putRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testPutFail($I, $example, HttpCode::NOT_FOUND);
}

/**
 * @example{"role":"admin", "id":"1", "expected":{"userId": "1", "typeId":"1", "amount":"29.25087515", "rate":"0.07", "status": "pending", "createdAt":"2017-08-24 11:37:15"}}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function getByIdRestricted(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testGetByIdFail($I, $example, HttpCode::NOT_FOUND);
}


/**
 * @return array
 */
protected function createData(): array {
	return [
		"userId" => "1",
		"typeId" => "1",
		"amount" => "29.25087515",
		"rate"   => "0.07",
		"status" => "active",
	];
}

//protected function putData() ** RESTRICTED


/**
 *  GET /balance
 */

/**
 * @example{"role":"user", "url":"/balance", "expected":[{"balance":"89.45168110"}]}
 * @example{"role":"admin", "url":"/balance", "expected":[{"balance":"24.95167998"}]}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function testGetBalance(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testActionPositive($I, $example);
}

/**
 * @example{"role":"admin", "allowed":"GET", "url":"/balance"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function restrictedForGetBalance(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testRestrictedMethods($I, $example);
}


/**
 *  GET /status/<status>
 */

/**
 * @example{"role":"user", "url":"/status", "expected":[{"id":2,"userId":2,"status":"completed","type":{"id":1}}, {"id":3,"userId":2,"status":"active","type":{"id":1}}, {"id":4,"userId":2,"status":"active","type":{"id":1}}]}
 * @example{"role":"user", "url":"/status/active", "expected":[{"id":3,"userId":2,"status":"active","type":{"id":1}}, {"id":4,"userId":2,"status":"active","type":{"id":1}}], "absent":[{"status":"completed"},{"status":"canceled"},{"status":"pending"}]}
 * @example{"role":"user", "url":"/status/completed", "expected":[{"id":2,"userId":2,"status":"completed","type":{"id":1}}], "absent":[{"status":"active"},{"status":"canceled"},{"status":"pending"}]}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function testGetParkingByStatus(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testActionPositive($I, $example);
}

/**
 * @example{"role":"user", "allowed":"GET", "url":"/status"}
 * @example{"role":"user", "allowed":"GET", "url":"/status/active"}
 * @example{"role":"user", "allowed":"GET", "url":"/status/complete"}
 * @example{"role":"user", "allowed":"GET", "url":"/status/pending"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function restrictedForGetParkingByStatus(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testRestrictedMethods($I, $example);
}


/**
 *  GET /admin-status/<status>
 */

/**
 * @example{"role":"admin", "url":"/admin-status", "expected":[{"id":1,"userId":1,"status":"pending","type":{"id":1}}, {"id":2,"userId":2,"status":"completed","type":{"id":1}},{"id":3,"userId":2,"status":"active","type":{"id":1}},{"id":4,"userId":2,"status":"active","type":{"id":1}},{"id":5,"userId":3,"status":"active","type":{"id":1}},{"id":6,"userId":4,"status":"active","type":{"id":1}}]}
 * @example{"role":"admin", "url":"/admin-status/active", "expected":[{"id":3,"userId":2,"status":"active","type":{"id":1}},{"id":4,"userId":2,"status":"active","type":{"id":1}},{"id":5,"userId":3,"status":"active","type":{"id":1}},{"id":6,"userId":4,"status":"active","type":{"id":1}}], "absent":[{"status":"completed"},{"status":"canceled"},{"status":"pending"}]}
 * @example{"role":"admin", "url":"/admin-status/completed", "expected":[{"id":2,"userId":2,"status":"completed","type":{"id":1}}], "absent":[{"status":"active"},{"status":"canceled"},{"status":"pending"}]}
 *
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function testGetAdminParkingByStatus(\FunctionalTester $I, \Codeception\Example $example): void	{

	$this->testActionPositive($I, $example);
}


/**
 *  GET /count
 */

/**
 * @example{"role":"user", "url":"/count", "expected":[{"active":2}, {"completed":1}, {"pending":0}, {"canceled":0}, {"total":3}]}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function testGetParkingsCount(\FunctionalTester $I, \Codeception\Example $example): void {

	//#MOVE $this->testActionPositive($I, $example);
}

/**
 * @example{"role":"user", "allowed":"GET", "url":"/count"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function restrictedForGetParkingCount(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testRestrictedMethods($I, $example);
}


/**
 *  GET /admin-count
 */

/**
 * @example{"role":"admin", "url":"/admin-count", "expected":[{"pending":1},{"active":4},{"canceled":0},{"completed":1},{"total":6}]}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function testGetAdminParkingsCount(\FunctionalTester $I, \Codeception\Example $example): void {

	//#UNSTABLE_TEST $this->testActionPositive($I, $example);
}

/**
 * @example{"role":"admin", "allowed":"GET", "url":"/admin-count"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function restrictedForGetAdminParkingCount(\FunctionalTester $I, \Codeception\Example $example): void {

	$this->testRestrictedMethods($I, $example);
}


/**
 *  POST /activate
 *  POST /cancel
 */

/**
 * @example{"role":"admin", "id":1, "url":"/activate", "status":"active"}
 * @example{"role":"admin", "id":1, "url":"/cancel", "status":"canceled"}
 *
 * @param \FunctionalTester $I
 * @param \Codeception\Example $example
 */
public function testSetParkingStatus(\FunctionalTester $I, \Codeception\Example $example): void {

	Test::double(FinanceParking::class, ['validateAmount' => null]);

	list($data, $role) = $this->getTestRoleData($example, HttpCode::OK);
	$this->setUser($I, $role);

	$data['expected'] = ["id" => $data['id'], "status" => $data['status']];
	$data['ckeckUrl'] = $this->url .'/admin-status/'. $data['status'];

	$I->sendGET(\Yii::$app->getUrlManager()->createUrl($data['ckeckUrl']));
	$I->seeResponseCodeIs(HttpCode::OK);
	$I->seeResponseIsJson();
	$I->dontSeeResponseContainsJson($data['expected']);

	$I->sendPOST(\Yii::$app->getUrlManager()->createUrl($this->url . $data['url']), ['id' => $data['id']]);

	$I->sendGET(\Yii::$app->getUrlManager()->createUrl($data['ckeckUrl']));
	//#UNSTABLE_TEST $I->seeResponseCodeIs(HttpCode::OK);
	$I->seeResponseIsJson();
	//#UNSTABLE_TEST $I->seeResponseContainsJson($data['expected']);
}






public function Success(\FunctionalTester $I) {

}


public function Fail(\FunctionalTester $I) {

}

public function Success(\FunctionalTester $I) {

}


public function Fail(\FunctionalTester $I) {

}

public function Success(\FunctionalTester $I) {

}


public function Fail(\FunctionalTester $I) {

}

public function Success(\FunctionalTester $I) {

}


public function Fail(\FunctionalTester $I) {

}

public function Success(\FunctionalTester $I) {

}


public function Fail(\FunctionalTester $I) {

}

