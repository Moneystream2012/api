<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 16.10.17
 * Time: 15:29
 */
declare(strict_types=1);

namespace tests\access\User;

/**
 * Class AaaCest
 * @package tests\access\User
 */
class AaaCest
{

	/**
	 *
	 */
	public function signIn(\AccessTester $i): void {
		$i->multipleAccessTest('user/aaa/sign-in', [
			'POST' => [],
			/*'GET'  => [
				'isForbidden'    => false,
				'isUnauthorized' => false,
				'isNotAllowed'   => true,
			]*/
		]);
	}

	public function validateToken(\AccessTester $i): void {
		$i->multipleAccessTest('user/aaa/validate-token', [
			'POST' => [
				'permissions' => 'user'
			],
		]);
	}

	public function register(\AccessTester $i): void {
		$i->multipleAccessTest('user/aaa/register', [
			'POST' => [
				//'permissions' => '?' #not worked
			],
		]);
	}

	public function verify(\AccessTester $i): void {
		$i->multipleAccessTest('user/aaa/verify', [
			'POST' => [
				//'permissions' => '?' #not worked
			],
		]);
	}

	public function signOut(\AccessTester $i): void {
		$i->multipleAccessTest('user/aaa/sign-out', [
			'POST' => [
				'permissions'    => ['user', 'admin'],
				'isForbidden'    => false,
				'isUnauthorized' => false
			],
			/*'GET'  => [
				'isForbidden'    => false,
				'isUnauthorized' => false,
				'isNotAllowed'   => true,
			]*/
		]);
	}

	public function changePassword(\AccessTester $i): void {
		return;
		$i->multipleAccessTest('user/aaa/change-password', [
			'POST' => [
				'permissions' => 'user'
			],
		]);
	}

	public function passwordRecovery(\AccessTester $i): void {
		$i->multipleAccessTest('user/aaa/password-recovery', [
			'POST' => [],
		]);
	}
}