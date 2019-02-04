<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 14.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use yii\db\ActiveQuery;
use App\Modules\Finance\Components\FinanceModelFactory;

class FinanceParkingType extends \App\Modules\Database\FinanceParkingType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rate', 'period'], 'required'],
            [['name'], 'string', 'min' => 3, 'max' => 10],
            [['name'], 'match', 'pattern' => '/^[A-Za-z0-9 \.,]+$/'],
            [['rate'], 'number', 'min' => 0],
            [['period'], 'integer', 'min' => 1, 'max' => 86313600], // max 999 days
            [['name', 'rate', 'period'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'name',
            'rate',
            'period',
        ];
    }
}
