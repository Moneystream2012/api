<?php
/**
 * @author Tarasenko Andrii
 * @date: 13.09.17
 */

declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use App\Components\BaseModel;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Models\UserAuthAccess;
use yii\base\Exception;
use yii\base\Model;
use yii\base\UserException;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class ChangePasswordModel
 * @package App\Modules\User\Controllers\Aaa
 */
class PasswordRecoveryModel extends Model
{
	/**
	 *
	 */
	public const SCENARIO_CHECK_ADDRESS = 'checkAddress';
	/**
	 *
	 */
	public const SCENARIO_CHANGE_PASSWORD = 'changePassword';

	/**
	 * @var
	 */
	public $address;

	/**
	 * @var
	 */
	public $word;

	/**
	 * @var
	 */
	public $sign;

	/**
	 * @var
	 */
	public $resetToken;

	/**
	 * @var
	 */
	public $password;

	/**
	 * @var
	 */
	public $passwordRepeat;

    /* @var UserAuthAccess */
    private $dbModelClass;

	/**
	 *
	 */
	public function init() {
		$this->dbModelClass = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS);
	}

	/**
	 * @return array
	 */
	public function rules(): array {
        return [
            [['address', 'word', 'sign'], 'required', 'on' => [static::SCENARIO_CHECK_ADDRESS]],
            [
            	['address','password', 'passwordRepeat', 'resetToken'],
	            'required',
	            'on' => [static::SCENARIO_CHANGE_PASSWORD]
            ],
            [['address'], 'verifyAddress', 'on' => [static::SCENARIO_CHECK_ADDRESS, static::SCENARIO_CHANGE_PASSWORD]],
            [
            	['password'],
	            'compare',
	            'compareAttribute' => 'passwordRepeat',
	            'operator' => '===',
	            'on' => [static::SCENARIO_CHANGE_PASSWORD]
            ],
            [['resetToken'], 'verifyToken', 'on' => static::SCENARIO_CHANGE_PASSWORD],
            [['sign'], 'verifySign', 'on' => [ static::SCENARIO_CHECK_ADDRESS ]],
            [['password', 'passwordRepeat'], 'string', 'min' => 5],
        ];
	}

	/**
	 * @param $attribute
	 * @param $params
	 */
	public function verifySign($attribute, $params): void {
		try {
			if (!\Yii::$app->minexnode->verifyMessage($this->address, $this->$attribute, $this->word)) {
				$this->addError($attribute, \Yii::t('app', 'Wrong verification signature'));
			}
		} catch (\Exception $e) {
			$this->addError($attribute, \Yii::t('app', 'Wrong verification signature'));
		}
	}

	/**
	 * @param $attribute
	 * @param $params
	 */
	public function verifyAddress($attribute, $params): void {
		$model = $this->dbModelClass::findOne(['address' => $this->$attribute]);

		if (empty($model)) {
			$this->addError($attribute, \Yii::t('app', 'Address not found'));
		}

	}

	/**
	 * @param $attribute
	 * @param $params
	 */
	public function verifyToken($attribute, $params): void {
		$model = $this->dbModelClass::findOne(['address' => $this->address]);

		if (empty($model) || $model->resetToken !== $this->$attribute || $model->tokenIsExpired()) {
			$this->addError('address', \Yii::t('user', 'Not valid data'));
		}
	}

	/**
	 * @return bool
	 */
	public function updateTokenInDb(): bool {

        $model = $this->dbModelClass::findOne(['address' => $this->address]);

        $model->resetToken = \Yii::$app->security->generateRandomString();
	    $model->resetTokenExpired = \Yii::$app->formatter->asDatetime(time() + 60 * 15, $this->dbModelClass::DB_DATE_TIME_FORMAT);

        $saved = $model->save();

        if (!$saved) {
            $this->addErrors($model->errors);
        }

        $this->resetToken = $model->resetToken;

        return $saved;
	}


	/**
	 * @return bool
	 */
	public function changePasswordInDb(): bool {
        $model = $this->dbModelClass::findOne(['address' => $this->address]);

        $model->password = \Yii::$app->security->generatePasswordHash($this->password);
        $model->is_password_changed = 1;

        return $model->save();
	}

	/**
	 * @param string $scenario
	 * @return bool
	 */
	public static function validateScenario(string $scenario): bool {
		return in_array($scenario, [
			static::SCENARIO_CHECK_ADDRESS,
			static::SCENARIO_CHANGE_PASSWORD
		]);
	}
}
