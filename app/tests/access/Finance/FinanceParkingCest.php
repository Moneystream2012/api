<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 26.10.17
 * Time: 13:05
 */
declare(strict_types=1);

namespace tests\access\Finance;

/**
 * Class FinanceParkingCest
 * @package tests\access\Finance
 */
class FinanceParkingCest
{

	public function index(\AccessTester $I): void {
		$I->sendRequest('POST', 'finance/parking', 'support', false, true, false);
		$I->multipleAccessTest('finance/parking', [
			'GET' => [
				'permissions' => 'admin'
			],
			'POST' => [
				'permissions' => 'user'
			],
			'PUT' => [],
			'DELETE' => [],
			'HEAD' => ['isNotAllowed' => true],
			'LINK' => [],
			'UNLINK' => [],
			'PATCH' => []
		]);
	}


	public function balance(\AccessTester $I): void {
		$I->multipleAccessTest('finance/parking/balance', [
			'GET' => [
				'permissions' => 'user'
			]
		]);
		$I->sendRequest('GET', 'finance/parking/balance', null, true);
	}


	public function status(\AccessTester $I): void {
		$I->multipleAccessTest('finance/parking/status', [
			'GET' => [
				'permissions' => 'user'
			]
		]);
		$I->sendRequest('GET', 'finance/parking/status', null, true);
	}


	public function adminStatus(\AccessTester $I): void {
		$I->sendRequest('GET', 'finance/parking/admin-status', 'support', false, true);
		$I->multipleAccessTest('finance/parking/admin-status', [
			'GET' => [
				'permissions' => 'admin'
			]
		]);
	}


	public function count(\AccessTester $I): void {
		$I->comment('Not run. Extra Patterns error');
		/*$I->multipleAccessTest('finance/parking/total-count', [
			'GET' => [
				'permissions' => ['user']
			]
		]);
		$I->sendRequest('GET', 'finance/parking/total-count', null, true);*/
	}


	public function adminCount(\AccessTester $I): void {
		$I->sendRequest('GET', 'finance/parking/admin-count', 'support', false, true);
		$I->multipleAccessTest('finance/parking/admin-count', [
			'GET' => [
				'permissions' => 'admin'
			]
		]);
	}


	public function cancel(\AccessTester $I): void {
		$I->multipleAccessTest('finance/parking/cancel', [
			'POST' => [
				'permissions' => 'user'
			]
		]);
		$I->sendRequest('POST', 'finance/parking/cancel', null, true);
	}


	public function activate(\AccessTester $I): void {
		$I->multipleAccessTest('finance/parking/activate', [
			'POST' => [
				'permissions' => 'user'
			]
		]);
		$I->sendRequest('POST', 'finance/parking/activate', null, true);
	}


	public function statistic(\AccessTester $I): void {
		$I->sendRequest('GET', 'finance/parking/statistic', 'support', false, true);
		$I->multipleAccessTest('finance/parking/statistic', [
			'GET' => [
				'permissions' => ['admin']
			]
		]);
	}

}