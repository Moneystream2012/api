<?php
/**
 * @author Tarasenko Andrii
 * @date: 13.09.17
 */

declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use yii\base\Model;

/**
 * Class ChangePasswordModel
 * @package App\Modules\User\Controllers\Aaa
 */
class ChangePasswordModel extends Model
{

	/**
	 * @var
	 */
    public $oldPassword;

	/**
	 * @var
	 */
	public $password;

	/**
	 * @var
	 */
	public $repeatPassword;

	/**
	 * @var
	 */
	public $model;

	/**
	 * @return array
	 */
	public function rules(): array {

        return [
            [['oldPassword', 'password', 'repeatPassword'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'repeatPassword', 'operator' => '==='],
            [['oldPassword'], 'verifyPassword'],
            [['password', 'repeatPassword'], 'string', 'min' => 5],
        ];
	}

	/**
	 * @param $attribute
	 * @param $params
	 */
	public function verifyPassword($attribute, $params): void {
		if (!\Yii::$app->security->validatePassword($this->oldPassword, $this->model->password)) {
			$this->addError($attribute, 'Old password not valid');
		}
	}
}
