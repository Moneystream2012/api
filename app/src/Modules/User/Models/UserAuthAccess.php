<?php

namespace App\Modules\User\Models;

use App\Interfaces\AppModel;
use App\Modules\User\Components\UserModelFactory;

/**
 * Class UserAuthAccess
 * @package App\Modules\User\Model
 */
class UserAuthAccess extends \App\Modules\Database\UserAuthAccess implements AppModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            [
                [['password'], 'string', 'min' => 6],
                [['address'], 'unique', 'message' => \Yii::t('user', 'Not valid data.')],
            ],
            parent::rules()
        );
    }

	public function fields() {
		return [
			'id',
			'address',
			'lastEnter',
			'tfauthActive',
			'tfauthCode',
			'userId',
			'resetToken',
			'resetTokenExpired'
		];
	}

	public function getUser() {
		return $this->hasOne(UserModelFactory::getClass(UserModelFactory::USER), ['id' => 'userId']);
	}

	public function needChange(): bool
    {
        return $this->is_password_changed == 0;
    }

    public function tokenIsExpired(): bool {
        return $this->resetTokenExpired < \Yii::$app->formatter->asDatetime(time(), static::DB_DATE_TIME_FORMAT);
    }
}
