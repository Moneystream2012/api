<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

use App\Modules\User\Models\UserAuthAccess;
use Exception;

/**
 * Class RegisterModel
 * @package App\Modules\User\Controllers\Aaa
 */
class RegisterModel extends \yii\base\Model
{

    /**
     * @var null
     */
    public $address = null;

    /**
     * @var null
     */
    public $password = null;

    /**
     * @var null
     */
    public $sign = null;

    /**
     * @var null
     */
    public $repeatPassword = null;

    /**
     * @var null
     */
    public $word = null;

    public const SCENARIO_VERIFY_ADDRESS = 'SCENARIO_VERIFY_ADDRESS';
    public const SCENARIO_VALIDATE_USER_AUTH  = 'SCENARIO_VALIDATE_USER_AUTH';
    public const SCENARIO_VERIFY_ADDRESS_EXISTS = 'SCENARIO_VERIFY_ADDRESS_EXISTS';

    /**
     * @inheritdoc
     */
	public function rules(): array {
        return [
            [['address', 'password', 'repeatPassword', 'sign', 'word'], 'required'],
            [['address'], 'required', 'on' => static::SCENARIO_VERIFY_ADDRESS_EXISTS],
            [['address'], 'exist', 'targetClass' => UserAuthAccess::class, 'on' => static::SCENARIO_VERIFY_ADDRESS_EXISTS],
            [['address'], 'string', 'min' => 24, 'max' => 64],
            [['address'], 'unique', 'targetClass' => UserAuthAccess::class, 'on' => static::SCENARIO_DEFAULT],
            [['password', 'repeatPassword'], 'string', 'min' => 5],
            [['password'], 'compare', 'compareAttribute' => 'repeatPassword'],
            [['word'], 'string', 'min' => 1, 'max' => 64],
            [['sign'], 'verifySign']
        ];
	}

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_VERIFY_ADDRESS_EXISTS] = ['address'];
        $scenarios[self::SCENARIO_VERIFY_ADDRESS] = ['address'];
        $scenarios[self::SCENARIO_VALIDATE_USER_AUTH] = ['address', 'password'];
        return $scenarios;
    }

    /**
     * @return array
     */
    public static function getAllScenarios(): array
    {
        return [
            self::SCENARIO_VERIFY_ADDRESS,
            self::SCENARIO_VALIDATE_USER_AUTH,
            self::SCENARIO_VERIFY_ADDRESS_EXISTS
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array {
        return [
            'address',
            'password',
            'repeatPassword',
            'sign',
            'word'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array {
        return [
            'address'        => 'Address',
            'password'       => 'Password',
            'repeatPassword' => 'Repeat Password'
        ];
    }

	public function verifySign($attribute, $params) {
        $message = 'Wrong verification signature';

        try
        {
            if (!\Yii::$app->minexnode->verifyMessage($this->address, $this->sign, $this->word)) {
                $this->addError($attribute, $message);
            }
        }
        catch (Exception $e)
        {
        	\Yii::error($e->getMessage());
            $this->addError($attribute, $message);
        }
	}
}