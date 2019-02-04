<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 02.08.17
 * Time: 15:08
 */

namespace App\Modules\User\Components;


use yii\web\IdentityInterface;

/**
 * Interface AppIdentityInterface
 * @package App\Modules\User\Components
 */
interface AppIdentityInterface extends IdentityInterface
{
    /**
     * @return mixed
     */
    public function getUserInfo(): array;
}
