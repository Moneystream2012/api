<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.09.17
 * Time: 17:48
 */

declare(strict_types=1);

namespace App\Modules\Chat;

class ChatModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = __NAMESPACE__ . '\Controllers';
}
