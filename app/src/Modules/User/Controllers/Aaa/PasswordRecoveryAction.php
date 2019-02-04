<?php
/**
 * @author Tarasenko Andrii
 * @date: 05.10.17
 */

declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use yii\base\Model;
use yii\rest\Action;
use yii\web\BadRequestHttpException;

/**
 * Class PasswordRecoveryAction
 * @package App\Modules\User\Controllers\Aaa
 */
class PasswordRecoveryAction extends Action
{

    /**
     * @var PasswordRecoveryModel
     */
    public $modelClass;

    /**
     * @return PasswordRecoveryModel|array|null
     * @throws BadRequestHttpException
     */
    public function run() {
        $post = \Yii::$app->request->post();

	    $scenario = empty($post['scenario']) ? $this->modelClass::SCENARIO_CHECK_ADDRESS : $post['scenario'];

        if (!$this->modelClass::validateScenario($scenario)) {
            throw new BadRequestHttpException('Not valid data');
        }

        /* @var PasswordRecoveryModel $model */
        $model = new $this->modelClass(['scenario' => $scenario]);

        $model->load($post, '');

        $result = null;
        switch ($scenario) {
            case $this->modelClass::SCENARIO_CHANGE_PASSWORD:
                $result = $this->changePassword($model);
                break;
            case $this->modelClass::SCENARIO_CHECK_ADDRESS:
                $result = $this->checkAddress($model);
                break;
        }

        return $result;
    }

    /**
     * @param PasswordRecoveryModel $model
     * @return PasswordRecoveryModel|array
     */
    private function changePassword(PasswordRecoveryModel $model) {

        return $model->validate() && $model->changePasswordInDb()
            ? ['success' => true]
            : $model;
    }

    /**
     * @param PasswordRecoveryModel $model
     * @return PasswordRecoveryModel|array
     */
    private function checkAddress(PasswordRecoveryModel $model) {

        return $model->validate() && $model->updateTokenInDb()
            ? ['resetToken' => $model->resetToken]
            : $model;
    }
}
