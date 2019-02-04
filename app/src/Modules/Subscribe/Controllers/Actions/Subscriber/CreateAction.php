<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 02.10.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Controllers\Actions\Subscriber;

use App\Modules\Subscribe\Models\Subscriber;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Models\User;
use Yii;
use yii\base\Exception;
use yii\web\ServerErrorHttpException;

/**
 * Class CreateAction
 * @package App\Modules\Subscribe\Controllers\Actions\Subscriber
 */
class CreateAction extends \yii\rest\Action
{

    /**
     * @inheritdoc
     */
    public function run()
    {

        /* @var $model Subscriber */
        $model = new $this->modelClass();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($model->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);

                $userClass = UserModelFactory::getClass(UserModelFactory::USER);
                /* @var $user User */
                $user = $userClass::findOne(Yii::$app->user->id);

                if (empty($user)) {
                    $user = new $userClass();
                }

                $user->email = $model->email;
                $user->notification = 1;

                if (!$user->save()) {
                    Yii::info($user->errors);
                    throw new Exception('User data not updated');
                }
                
            }elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }

            $transaction->commit();

        } catch(\Throwable $exception) {
            $transaction->rollBack();
            throw new ServerErrorHttpException($exception->getMessage());
        }

        return $model;
    }

}