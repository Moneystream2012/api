<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 21.11.17
 * Time: 16:08
 */

namespace App\Commands\Transfer\Models;


class FinanceParking extends \App\Modules\Finance\Models\FinanceParking
{
    public function beforeSave($insert): bool
    {
        return true;
    }
}
