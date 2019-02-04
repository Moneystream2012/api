<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);


namespace App\Modules\User\Controllers\Aaa;

use App\Components\BaseAction;
use App\Modules\User\{
	Components\UserModelFactory,
	Modules\JWT\JWTIdentity
};
use yii\db\Transaction;


/**
 * Class RegisterAction
 * @package App\Modules\User\Controllers\Aaa
 */
class RegisterAction extends BaseAction
{
	/**
	 * @var Transaction
	 */
	private $transaction = null;

    /**
     * @var RegisterModel
     */
    public $modelClass = null;

    public function run() {

    	$this->transaction = \Yii::$app->db->beginTransaction();


    	try {
		    /** @var \App\Modules\User\Models\User $user */
		    $user = UserModelFactory::create(UserModelFactory::USER);
		    $user->lastSync = \Yii::$app->formatter->asDatetime(0);
		    $user->moderatorId = $user::MODERATOR_ID;
		    if(!$user->insert()) {
		    	$this->transaction->rollBack();
			    return $user;
		    }
		    /** @var \App\Modules\User\Models\UserAuthAccess $userAuth */
		    $userAuth = UserModelFactory::create(UserModelFactory::USER_AUTH_ACCESS);
		    $userAuth->userId = $user->id;
		    $userAuth->address = $this->modelClass->address;
		    $userAuth->password = $this->modelClass->password;
		    $userAuth->lastEnter = \Yii::$app->formatter->asDatetime(time());

		    if(!$userAuth->validate()) {
			    $this->transaction->rollBack();
			    return $userAuth;
		    }

		    $userAuth->password = \Yii::$app->security->generatePasswordHash($this->modelClass->password);

		    if(!$userAuth->save()) {
			    $this->transaction->rollBack();
			    return $userAuth;
		    }

		    \Yii::$app->amqpRPCClient->createRequest(
			    'App\Modules\Finance\Worker\FinanceRPC',
			    'createAddressBalance',
			    [$this->modelClass->address]
		    );

		    $JWTIdentity = JWTIdentity::createSession($user->id, $userAuth->address, []);
		    \Yii::$app->user->login($JWTIdentity);

		    #Assign role no new user
		    \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole('user'), $JWTIdentity->getId());

		    $this->transaction->commit();
	    } catch (\Exception $e) {
		    $this->transaction->rollBack();
		    throw $e;
	    }

		return \Yii::$app->user->sendUserData();
    }
}