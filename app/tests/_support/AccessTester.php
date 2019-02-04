<?php

use App\Components\BaseAction;
use App\Helpers\Arr;
use AspectMock\Test;
use Codeception\Util\HttpCode;
use yii\base\Action;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AccessTester extends \Codeception\Actor
{
    use _generated\AccessTesterActions;

	/**
	 *
	 */
	const USER_ID = 1;

	/**
	 * @param string $method
	 * @param string $link
	 */
    public function sendRequest(
    	string $method,
	    string $link,
	    string $permission = null,
	    bool $isUnauthorized = false,
	    bool $isForbidden = false,
		bool $isNotAllowed = false
    ): void {

	    Test::double(Action::class, ['runWithParams' => ['request' => 'success']]);
	    Test::double(BaseAction::class, ['runWithParams' => ['request' => 'success']]);
	    Test::double(\yii\base\ErrorHandler::class, ['logException' => true]);

	    if ($permission != null) {
		    $this->amLoggedInAs(new \tests\_data\functional\Modules\User\FakeIdentity(self::USER_ID));
			//\Yii::$app->user->switchIdentity();

		    $permissionList = [
			    $permission => new \yii\rbac\Assignment([
				    'userId' => self::USER_ID,
				    'roleName' => $permission,
				    'createdAt' => time(),
			    ])
		    ];
		    Test::double(\yii\rbac\DbManager::class, ['getAssignments' => $permissionList]);
			$this->comment('Use permission: ' . $permission);
	    }

	    $link = \Yii::$app->getUrlManager()->createUrl($link);

	    $methods = $this->testedMethods();
	    if (in_array($method, $methods, true)) {
		    $this->getScenario()->runStep(new \Codeception\Step\Action('send' . $method, [$link, []]));
	    } else {
	    	$this->fail('Method '.$method. ' not allowed in test system');
	    }
	    Test::clean();

	    if($isNotAllowed) {
		    $this->canSeeResponseContainsJson($this->methodNotAllowedBodyError());
		    $this->canSeeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	    }elseif($isUnauthorized) {
		    $this->canSeeResponseContainsJson($this->loginRequiredBodyError());
		    $this->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
	    } elseif ($isForbidden) {
		    $this->canSeeResponseContainsJson($this->forbiddenBodyError());
		    $this->canSeeResponseCodeIs(HttpCode::FORBIDDEN);
	    } else {
		    $this->canSeeResponseCodeIs(HttpCode::OK);
		    $this->canSeeResponseContainsJson(['request' => 'success']);
	    }

    }

	/**
	 * @return array
	 */
	protected function testedMethods(): array {
		return [
			'POST',
			'GET',
			'PUT',
			'DELETE',
			'HEAD',
			'PATCH',
			'LINK',
			'UNLINK',
		];
	}

	/**
	 * @return array
	 */
	protected function loginRequiredBodyError(): array {
		return [
			'name' => 'Unauthorized',
			'message' => 'Login Required',
			'code' => 0,
			'status' => HttpCode::UNAUTHORIZED
		];
	}

	/**
	 * @return array
	 */
	protected function forbiddenBodyError(): array {
		return [
			'name' => 'Forbidden',
			'message' => 'You are not allowed to perform this action.',
			'code' => 0,
			'status' => HttpCode::FORBIDDEN
		];
	}

	protected function methodNotAllowedBodyError(): array {
		return [
			'name' => 'Method Not Allowed',
			//'message' => 'Method Not Allowed. This url can only handle the following request methods:*********',
			'code' => 0,
			'status' => HttpCode::METHOD_NOT_ALLOWED
		];
	}

	/**
	 *
	 */
	public function multipleAccessTest(string $url, array $params, bool $runNegative = true) {

		foreach ($params as $method => $context) {
			$permissions = Arr::getValue($context, 'permissions');
			if (is_array($permissions)) {
				foreach ($permissions as $permission) {
					$this->sendRequest(
						$method,
						$url,
						$permission,
						Arr::getValue($context, 'isUnauthorized', false),
						Arr::getValue($context, 'isForbidden', false),
						Arr::getValue($context, 'isNotAllowed', false)
					);
				}
			} else {
				$this->sendRequest(
					$method,
					$url,
					Arr::getValue($context, 'permissions'),
					Arr::getValue($context, 'isUnauthorized', false),
					Arr::getValue($context, 'isForbidden', false),
					Arr::getValue($context, 'isNotAllowed', false)
				);
			}
			#TODO unstable logic
			/*$this->sendRequest(
				$method,
				$url,
				null, //none permission
				true, //isUnauthorized
				false //isUnauthorized
			);*/
		}//
		if($runNegative) {


			$forbiddenMethods = $this->testedMethods();
			$allowMethods = array_keys($params);
			$forbiddenMethods = Arr::removeSeveral($forbiddenMethods, $allowMethods);
			foreach ($allowMethods as $item) {
				Arr::removeValue($forbiddenMethods, $item);
			}
			//var_dump($forbiddenMethods);
			//die();
			foreach ($forbiddenMethods as $method) {
				$this->sendRequest(
					$method,
					$url,
					null, //none permission
					false, //isUnauthorized
					false, //isForbidden
					true //isNotAllowed
				);
			}
		}
	}
}
