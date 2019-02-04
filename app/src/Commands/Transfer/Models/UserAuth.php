<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 24.10.17
 * Time: 17:34
 */

namespace App\Commands\Transfer\Models;


use App\Commands\Transfer\Exception\TransferException;
use App\Modules\Database\AuthAssignment;
use App\Modules\User\Models\User;
use yii\db\Query;

class UserAuth
{
    public function createUserAssignments()
    {
        $query = (new Query())->from('{{%user}}')->orderBy('id');

        foreach ($query->batch(20) as $users) {
            $userAuth = [];

            foreach ($users as $user) {

                $userAuthModel = AuthAssignment::find()->where(['user_id' => $user['id']])->one();

                if ($userAuthModel != null) {
                    $userAuthModel->delete();
                    \Yii::info('Delete old user ' . $userAuthModel->user_id);
                }

                $userAuth[] = [
                    User::USER_ROLE,
                    $user['id'],
                    time()
                ];
            }

            $result = \Yii::$app->db->createCommand()->batchInsert('{{%auth_assignment}}', ['item_name', 'user_id', 'created_at'], $userAuth)->execute();

            if ($result == false) {
                \Yii::error('Cant save auth assignments');
                throw new TransferException();
            }

            \Yii::info($userAuth);
        }

    }
}
