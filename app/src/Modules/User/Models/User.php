<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\User\Models;

use App\{
    Interfaces\AppModel, Modules\User\Components\UserModelFactory, Modules\User\Models\Query\UserQuery
};
use \yii\db\ActiveQuery;

/**
 * Class User
 * @package App\Modules\User\Model
 */
class User extends \App\Modules\Database\User implements AppModel
{

    public const MODERATOR_ID = 1;

    public const USER_ROLE = 'user';
    public const ADMIN_ROLE = 'admin';
    public const SUPPORT_ROLE = 'support';

    public function rules()
    {
        $rules = parent::rules();

        return array_merge([
            [['moderatorId'], 'default', 'value' => 1],
            [['lastSync'], 'default', 'value' => \Yii::$app->formatter->asDatetime(time())]
        ], $rules);
    }

    /**
     * @return UserQuery
     */
    public static function find() : ActiveQuery {
        return new UserQuery(get_called_class());
    }

	/**
	 * @return bool
	 */
    public function beforeValidate():bool {
        if ($this->isNewRecord) {
            $this->createdAt = $this->updatedAt = \Yii::$app->formatter->asDatetime(time());
        } else {
            $this->updatedAt = \Yii::$app->formatter->asDatetime(time());
        }
        return parent::beforeValidate();
    }

    public function getAuth(): ActiveQuery {
        return $this->hasOne(UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS), [ 'userId' => 'id']);
    }

    public function getBalance(): float {
        return (float)\Yii::$app->amqpRPCClient->createRequest(
            'App\Modules\Finance\Workers\FinanceRPC',
            'addressBalance',
            [$this->auth->address],
            true
        );
    }

    public function getParkingBalance(): float {
        return (float)\Yii::$app->amqpRPCClient->createRequest(
            'App\Modules\Finance\Workers\FinanceRPC',
            'addressParkingBalance',
            [$this->id],
            true
        );
    }

	public function fields(): array {
		return [
			'id',
			'username',
			'active',
			'notification',
			'email',
			'phone',
			'countryCode',
			'lastSync',
			'createdAt',
			'updatedAt',
			'moderatorId',
			'auth',
			'balance',
			'parkingBalance'
		];
	}

	public function getDataForAuth(): array {
        return [
            'username' => $this->username,
            'active' => $this->active,
            'notification' => $this->notification,
            'email' => $this->email,
        ];
    }
}
