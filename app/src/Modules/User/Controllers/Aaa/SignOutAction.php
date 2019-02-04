<?php
/**
 * @author Tarasenko Andrii
 * @date: 01.09.17
 */

declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use yii\helpers\Json;
use yii\rest\Action;

/**
 * Class SignOutAction
 * @package App\Modules\User\Controllers\Aaa
 */
class SignOutAction extends Action
{
	/**
	 * @return array
	 */
	public function run(): array {
		if(
			\Yii::$app->user->identity->destroySession() and
			\Yii::$app->user->logout())
		{

			return ['success' => true];
		}
		return ['success' => false];
	}
}
