<?php

use yii\db\Migration;

class m170830_095323_user_init_rback_rules extends Migration
{

	public const USER_ROLE = 'user';
	public const ADMIN_ROLE = 'admin';
	public const SUPPORT_ROLE = 'support';

    public function safeUp() {
		$auth = Yii::$app->authManager;

		$user = $auth->createRole(self::USER_ROLE);
		$auth->add($user);

		$support = $auth->createRole(self::SUPPORT_ROLE);
		$auth->add($support);

		$admin = $auth->createRole(self::ADMIN_ROLE);
		$auth->add($admin);

		$ownerRule = new \App\Components\Rbac\OwnerRule();
		$auth->add($ownerRule);

		$updateOwnItem = $auth->createPermission('updateOwnItem');
		$updateOwnItem->ruleName = $ownerRule->name;
		$auth->add($updateOwnItem);

		$auth->addChild($user, $updateOwnItem);
		$auth->addChild($admin, $user);
    }

    public function safeDown() {
		$auth = Yii::$app->authManager;
		$auth->removeAll();
    }

}
