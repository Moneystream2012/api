<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 14.11.17
 * Time: 17:14
 */

namespace App\Modules\Finance\Models\FinanceParking;


use App\Components\Math;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\FinanceParking;

class CreateParking extends FinanceParking
{
    /**
     * @inheritdoc
     */
    public function fields(): array {
        return [
            'id',
            'typeId',
            'amount',
            'rate',
            'status',
            'createdAt'
        ];
    }

    /**
     * Validation rules
     */
    public function rules() : array {
        return [
            [['typeId', 'amount'], 'required'],
            [['userId', 'typeId'], 'integer'],
            [['amount', 'rate'], 'number'],
            [['status'], 'default', 'value' => self::TYPE_ACTIVE],
            [['status'], 'string'],
            [['amount'], 'validateAmount'],
            [['typeId'], 'exist',
                'skipOnError' => true,
                'targetClass' => FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE),
                'targetAttribute' => ['typeId' => 'id']
            ],
            [['status'], 'in' , 'range' => self::getStatusRange()],
            [['userId', 'typeId', 'rate', 'status'], 'safe'],
        ];
    }

    public function beforeValidate()
    {
        $this->userId = \Yii::$app->user->id;

        return parent::beforeValidate();
    }


    public function validateAmount($attribute, $params, $validator): void {
        $type = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE)::findOne($this->typeId);

        if(empty($type)) {
            return;
        }

        $rate = (float)$type->rate;

        $amount = $this->$attribute * $rate / 100;

        $validAmount = ((float) $amount > 0.00001);
        if (!$validAmount) {
            $this->addError($attribute, 'Too small return amount: ' . number_format($amount, \Yii::$app->params['scale'], '.', ''));
            return;
        }

        $balance = 0;
        $balanceClass = FinanceModelFactory::getClass(FinanceModelFactory::ADDRESS_BALANCE);
        $userBalance = $balanceClass::findOne(['address' => \Yii::$app->user->address]);

        if (!empty($userBalance)) {
            $balance = $userBalance->balance;
        }


        $parkings = FinanceModelFactory::getClass(FinanceModelFactory::PARKING)
            ::find()
            ->filterStatus(['active'])
            ->ownedBy(\Yii::$app->user->id)
            ->asArray()
            ->all();

        $totalParkingAmount = 0;
        foreach ($parkings as $item) {
            $totalParkingAmount = Math::Add($totalParkingAmount, $item['amount'], \Yii::$app->params['scale']);
        }

        $availableBalance = Math::Sub($balance, $totalParkingAmount, \Yii::$app->params['scale']);

        $enoughMoney = Math::Comp($availableBalance, $this->$attribute, \Yii::$app->params['scale']) >= 0;

        if (!$enoughMoney) {
            $this->addError($attribute, 'Not enough money to create parking');
        }
    }
}
