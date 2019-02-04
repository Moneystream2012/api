<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * Date: 28.07.17, 03.10.17
 */

namespace tests\functional\Modules\User;

use tests\_support\AuthCest;
use tests\_support\AuthCestInterface;
use tests\fixtures\User\{
	UserAuthAssignmentFixture,
	UserFixture,
	UserAuthAccessFixture
};

/**
 * Class AAACest
 * @package tests\functional\Modules\User
 */
class AAACest implements AuthCestInterface
{
    use AuthCest;

	public function _fixtures(): array {
        return [
            UserFixture::class,
            UserAuthAccessFixture::class,
	        UserAuthAssignmentFixture::class
        ];
	}

    /**
     * @example(address="foobarfoobarfoobarfoobar", password="foobarroot")
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function signInSuccess(\FunctionalTester $I, \Codeception\Example $example): void {
        $I->sendPOST(
            \Yii::$app->getUrlManager()->createUrl('user/aaa/sign-in'),
	        ['address'  => $example['address'],
	         'password' => $example['password']
	        ]
        );
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->canSeeHttpHeader('token-type', 'Bearer JWT');
        $I->canSeeHttpHeader('access-token');
        $I->canSeeHttpHeader('userId');
        $I->canSeeResponseContainsJson([
            'status' => 'ok',
            'data'   => ['address' => $example['address']],
        ]);
	}

    /**
     * @example(address="foobarfoobarfoobarfoobar", password=" foobarroot")
     * @example(address="foobarfoobarfoobarfoobar", password="777foobarroot")
     * @example(address="foobarfoobarfoobarfoobar777", password="foobarroot")
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function signInFail(\FunctionalTester $I, \Codeception\Example $example): void {
        $data = $example->getIterator()->getArrayCopy();

        $I->sendPOST(
            \Yii::$app->getUrlManager()->createUrl('user/aaa/sign-in'),
            array_merge($this->getSignInData(), $data)
        );
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::UNPROCESSABLE_ENTITY);
        $I->canSeeResponseContains($this->getFirstKey($data));
	}

    /**
     * @param \FunctionalTester $I
     */
	public function signOut(\FunctionalTester $I): void {
		$this->startMockUser(self::USER_ID);
		$I->sendPOST(\Yii::$app->getUrlManager()->createUrl('user/aaa/sign-out'));
		$I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
		$I->canSeeResponseContainsJson(['success' => true]);
		$this->endMockUser();
	}

	/**
	 * @param \FunctionalTester $I
	 */
	public function registerSuccess(\FunctionalTester $I): void {
        $I->sendPOST(
            \Yii::$app->getUrlManager()->createUrl('user/aaa/register'),
            $data = $this->getRegisterData()
        );
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->canSeeResponseContainsJson([
            'status' => 'ok',
            'data' => ['address' => $data['address']],
        ]);
	}

    /**
     * @example(password="")
     * @example(repeatPassword="WrongRepeatPassword")
     * @example(sign="WrongSign")
     * @example(address="--WrongAddress--")
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function registerFail(\FunctionalTester $I, \Codeception\Example $example): void {
        $data = $example->getIterator()->getArrayCopy();

        $I->sendPOST(
            \Yii::$app->getUrlManager()->createUrl('user/aaa/register'),
            array_merge($this->getRegisterData(), $data)
        );
        $I->canSeeResponseIsJson();
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::UNPROCESSABLE_ENTITY);

        $key = $this->getFirstKey($data);
        $I->canSeeResponseContains(($key !== 'repeatPassword') ? $key : 'password');
	}

    /**
     * @param \FunctionalTester $I
     */
	public function validateToken(\FunctionalTester $I): void {
        $this->startMockUser(self::USER_ID);

	    $I->sendPOST(\Yii::$app->getUrlManager()->createUrl('user/aaa/validate-token'));
	    $I->canSeeResponseIsJson();
	    $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
	    $I->canSeeResponseContainsJson([
		    'status' => 'ok',
		    'data'   => [
			    'id'      => self::USER_ID,
			    'address' => 'XWtUA1qBvisvnyxKWyBpiRgRwQNX3xiYGS',
		    ]
	    ]);

	    $this->endMockUser();
	}

    /**
     * @example(oldPassword="foobaruser", password="barfoo", repeatPassword="barfoo")
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function changePasswordSuccess(\FunctionalTester $I, \Codeception\Example $example): void {
        $this->startMockUser(self::USER_ID);

	    $I->sendPOST(
		    \Yii::$app->getUrlManager()->createUrl('user/aaa/change-password'),
		    [
			    'oldPassword'    => $example['oldPassword'],
			    'password'       => $example['password'],
			    'repeatPassword' => $example['repeatPassword'],
		    ]
	    );
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->canSeeResponseContainsJson(['success' => true]);
        $this->endMockUser();
	}

    /**
     * @example(oldPassword="", password="barfoo", repeatPassword="barfoo")
     * @example(oldPassword="foobar", password="barfoo", repeatPassword="barfoo")
     * @example(oldPassword="foobarroot", password="barfoo", repeatPassword="123456")
     *
     * @param \FunctionalTester $I
     * @param \Codeception\Example $example
     */
	public function changePasswordFail(\FunctionalTester $I, \Codeception\Example $example): void {
		$this->startMockUser(self::USER_ID);

		$I->sendPOST(
			\Yii::$app->getUrlManager()->createUrl('user/aaa/change-password'),
			[
				'oldPassword'    => $example['oldPassword'],
				'password'       => $example['password'],
				'repeatPassword' => $example['repeatPassword'],
			]
		);
		$I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::UNPROCESSABLE_ENTITY);
		$I->canSeeResponseContainsJson(['success' => false]);

		$this->endMockUser();
	}


	/**
	 * @param \FunctionalTester $I
	 */
	public function passwordRecoverySuccess(\FunctionalTester $I): void {
		$I->sendPOST(
			\Yii::$app->getUrlManager()->createUrl('user/aaa/password-recovery'),
			[
				'address' => 'XWtUA1qBvisvnyxKWyBpiRgRwQNX3xiYGS',
				'word'    => 'MinexBank',
				'sign'    => 'HxkkEkrvavFdnHcIxk1BCOTKQsqFlFKLjNBY4mRNfL/PUFdM5D3KoeYGzh+kaYjM1a5MzYBmdx6XmbyP6vKtqEg=',
			]
		);
		$I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
	}

	/**
	 * @example(address="XWtUA1qBvisvnyxKWyBpiRgRwQNX3xiYGS", sign="wrongSign")
	 * @example(address="-------AddressNotFound------------", sign="wrongSign")
	 *
	 * @param \FunctionalTester $I
	 * @param \Codeception\Example $example
	 */
	public function passwordRecoveryFail(\FunctionalTester $I, \Codeception\Example $example): void {
		$I->sendPOST(
			\Yii::$app->getUrlManager()->createUrl('user/aaa/password-recovery'),
			[
				'address' => $example['address'],
				'word'    => 'MinexBank',
				'sign'    => $example['sign'],
			]
		);
		$I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::UNPROCESSABLE_ENTITY);
	}

    /**
     * @param array $data
     *
     * @return string
     */
    private function getFirstKey(array $data): string {
        $data = array_flip($data);
        return array_shift($data);
    }

    /**
     * @return array
     */
    private function getSignInData(): array {
        return [
            "address" => "foobarfoobarfoobarfoobar",
            "password" => "foobarroot",
        ];
    }

    /**
     * @return array
     */
    private function getRegisterData(): array {
        return [
            'address'        => 'XF61k5mSwXNN3wmj4nwXjx1gaepZjBq17v',
            'password'       => 'foobarfoo',
            'repeatPassword' => 'foobarfoo',
            'sign'           => 'H3dA20dx6AbUIAJ/RMwF58tsvTRdXz/dJCH58BzLCZXQDBzDRQJ4XgFev6QMntFLkXmNgf6NhtOLvdEegOilJCc=',
            'word'           => 'MinexBank',
        ];
    }
}