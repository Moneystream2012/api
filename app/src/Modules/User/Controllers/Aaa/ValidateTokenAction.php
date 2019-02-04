<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 01.08.17
 * Time: 17:51
 */

namespace App\Modules\User\Controllers\Aaa;

use App\Components\BaseAction;

/**
 * Class ValidateTokenAction
 * @package App\Modules\User\Controllers\Aaa
 */
class ValidateTokenAction extends BaseAction
{

    /**
     *
     */
    public function run() {
        \Yii::$app->user->sendUserData();
    }
}
