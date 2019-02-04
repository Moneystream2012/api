<?php
/**
 * @author Tarasenko Andrii
 * @date: 13.09.17
 */

declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use yii\rest\Action;

/**
 * Class ChangePasswordAction
 * @package App\Modules\User\Controllers\Aaa
 */
class ChangePasswordAction extends Action
{
    // todo: refactor
    public function run() {
        $result = ['success' => false];


	    /** @var \App\Modules\User\Models\UserAuthAccess $model */
	    $model = $this->modelClass::find()
            ->where(['userId' => \Yii::$app->user->id])
            ->one();

        $validateModel = new ChangePasswordModel(['model' => $model]);

        $validateModel->load(\Yii::$app->request->post(), '');

        if ($validateModel->validate()) {

            $model->password = \Yii::$app->security->generatePasswordHash($validateModel->password);

            if(!$model->save(false)) {
                \Yii::$app->response->statusCode = 422;
	            $result['inform'] = $model->getErrors();
            } else {
	            $result['success'] = true;
            }
        } else {
            \Yii::$app->response->statusCode = 422;
            $result['inform'] = $validateModel->getErrors();
        }

        return $result;
    }
}
