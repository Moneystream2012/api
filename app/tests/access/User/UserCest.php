<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 25.10.17
 * Time: 13:29
 */
declare(strict_types=1);

namespace tests\access\User;

/**
 * Class User
 * @package tests\access\User
 */
class UserCest
{

	/**
	 * @param \AccessTester $i
	 */
	public function index(\AccessTester $i): void {
		$i->multipleAccessTest('user/user', [
			'GET' => [
				'permissions' => 'admin'
			]
		]);
	}
}