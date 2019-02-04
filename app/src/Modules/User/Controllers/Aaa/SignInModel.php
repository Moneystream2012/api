<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);

namespace App\Modules\User\Controllers\Aaa;

/**
 * Class SignInModel
 * @package App\Modules\User\Controllers\AAA
 */
class SignInModel extends \yii\base\Model
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
    public $passwordRecovery = null;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['address', 'password'], 'required'],
            [['address'], 'string', 'min' => 24, 'max' => 64],
            [['passwordRecovery'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'address',
            'password'
        ];
    }


}

