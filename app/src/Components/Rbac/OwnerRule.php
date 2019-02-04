<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 30.08.17
 * Time: 17:17
 */
declare(strict_types=1);

namespace App\Components\Rbac;

use App\Interfaces\Editable;
use App\Modules\User\Models\User;
use yii\rbac\Rule;

class OwnerRule extends Rule
{
	public $name = 'ownerRule';

	public function execute($user, $item, $params)
	{
		if (isset($params['model'])) {
			return $this->checkOwner($params['model'], $user);
		}

		return false;
	}

	private function checkOwner(Editable $model, $user)
	{
		if (in_array(User::ADMIN_ROLE, array_keys(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)))) {
			return true;
		}

		return $model->getUserId() == $user;
	}
}
