<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 14.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use App\Modules\Finance\Components\FinanceModelFactory;
use \yii\db\ActiveQuery;

class FinanceTransaction extends \App\Modules\Database\FinanceTransaction
{
    public const TYPE_PENDING = 'pending';
    public const TYPE_COMPLETED = 'completed';
    public const TYPE_CANCELED = 'canceled';
    public const TYPE_BLANK = 'blank';

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['hash', 'parkingId', 'amount', 'fee'], 'required'],
            [['hash'], 'string', 'min' => 64, 'max' => 64],
            [['parkingId'], 'integer'],
            [['amount', 'fee'], 'number'],
            [['parkingId'], 'exist',
                'skipOnError' => true,
                'targetClass' => FinanceModelFactory::getClass(FinanceModelFactory::PARKING),
                'targetAttribute' => ['parkingId' => 'id']
            ],
            [['status'], 'in', 'range' => $this->getStatusRange()],
            [['createdAt', 'updatedAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['hash', 'parkingId', 'amount', 'fee', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'hash',
            'parkingId',
            'amount',
            'fee',
            'status',
            'createdAt',
            'updatedAt',
        ];
    }

    public function getStatusRange(): array
    {
        return [
            self::TYPE_PENDING,
            self::TYPE_COMPLETED,
            self::TYPE_CANCELED,
            self::TYPE_BLANK
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find(): ActiveQuery
    {
        return new Query\FinanceTransaction(get_called_class());
    }
}
