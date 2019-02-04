<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 17.08.17
 */

declare(strict_types=1);

namespace App\Modules\Explorer\Models;

class ExplorerInput extends \App\Modules\Database\ExplorerInput
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['transactionId', 'amount', 'address'], 'required'],
            [['transactionId'], 'string', 'min' => 64, 'max' => 64],
            [['address'], 'string', 'min' => 20, 'max' => 35],
            [['amount'], 'number'],
            [['transactionId', 'amount', 'address'], 'safe'],
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
            'amount',
            'address',
        ];
    }
}
