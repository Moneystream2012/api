<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 17.08.17
 */

declare(strict_types=1);

namespace App\Modules\Explorer\Models;

class ExplorerOutput extends \App\Modules\Database\ExplorerOutput
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionId', 'amount', 'address'], 'required'],
            [['transactionId'], 'string', 'min' => 64, 'max' => 64],
            [['address'], 'string', 'min' => 1, 'max' => 40],
            [['amount'], 'double'],
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
