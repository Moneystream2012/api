<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use App\Modules\Finance\Components\FinanceModelFactory;
use \yii\db\ActiveQuery;

class FinanceTransactionLog extends \App\Modules\Database\FinanceTransactionLog
{
    public const TYPE_PENDING = 'pending';
    public const TYPE_COMPLETED = 'completed';
    public const TYPE_CANCELED = 'canceled';

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['transactionId', 'status'], 'required'],
            [['transactionId'], 'integer'],
            [['status'], 'in', 'range' => $this->getStatusRange()],
            [['createdAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['transactionId', 'status', 'createdAt'], 'safe'],
            [['transactionId'], 'exist',
                'skipOnError' => true,
                'targetClass' => FinanceTransaction::className(),
                'targetAttribute' => ['transactionId' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'transactionId',
            'status',
            'createdAt',
        ];
    }

    public function getStatusRange(): array
    {
        return [
            self::TYPE_PENDING,
            self::TYPE_COMPLETED,
            self::TYPE_CANCELED,
        ];
    }
}
