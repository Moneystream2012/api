<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 09.10.17
 * Time: 18:54
 */

namespace App\Modules\User\Controllers\Aaa;

use yii\base\Action;
use Yii;
use yii\web\BadRequestHttpException;

/**
 * Class VerifyAction
 * @package App\Modules\User\Controllers\Aaa
 */
class VerifyAction extends Action
{
    /**
     * @var RegisterModel
     */
    public $modelClass = null;

    public function run()
    {
        $model = new $this->modelClass;
        $model->load(Yii::$app->request->post(), '');

        $scenario = Yii::$app->request->post('scenario');

        if (!in_array($scenario, $this->modelClass::getAllScenarios())) {
            throw new BadRequestHttpException();
        }

        $model->setScenario($scenario);

        if (!$model->validate()) {
            return $model;
        }

        return true;
    }
}
