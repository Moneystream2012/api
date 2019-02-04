<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 14.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use App\Modules\Finance\Components\FinanceModelFactory;
use yii\db\ActiveQuery;

class FinanceParkingLog extends \App\Modules\Database\FinanceParkingLog
{
    public const TYPE_PENDING = 'pending';
    public const TYPE_ACTIVE = 'active';
    public const TYPE_CANCELED = 'canceled';
    public const TYPE_COMPLETED = 'completed';

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['parkingId', 'status'], 'required'],
            [['parkingId'], 'integer'],
            [['status'], 'in', 'range' => $this->getStatusRange()],
            [['createdAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['parkingId'], 'exist',
                'skipOnError' => true,
                'targetClass' => FinanceParking::className(),
                'targetAttribute' => ['parkingId' => 'id']
            ],
            [['parkingId', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'parkingId',
            'status',
            'createdAt',
        ];
    }

    public function getStatusRange(): array
    {
        return [
            self::TYPE_PENDING,
            self::TYPE_ACTIVE,
            self::TYPE_CANCELED,
            self::TYPE_COMPLETED,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find(): ActiveQuery
    {
        return new Query\FinanceParkingLog(get_called_class());
    }
}
