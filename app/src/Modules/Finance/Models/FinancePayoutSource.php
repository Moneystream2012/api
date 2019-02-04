<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 07.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

class FinancePayoutSource extends \App\Modules\Database\FinancePayoutSource
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['address'], 'required'],
            [['address'], 'unique'],
            [['address'], 'string', 'min' => 28, 'max' => 35],
            [['address'], 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            [['createdAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['address'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'address',
            'createdAt',
        ];
    }

    /**
     * Obtain newest payout source address (for MNX change from transactions)
     *
     * @return string
     */
    public static function getNewestAddress(): string
    {
        $newest = self::find()->orderBy(['id' => SORT_DESC])->one();
        return ($newest && isset($newest['address'])) ? $newest['address'] : '';
    }
}
