<?php
/**
 * @author Tarasenko Andrii
 * @date: 06.09.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use App\Modules\Finance\Models\FinanceParking;
use Danhunsaker\BC;
use yii\rest\Action;

/**
 * Class CountAction
 * @package App\Modules\Finance\Controllers\Actions\Parking
 */
class CountAction extends Action
{

    public function run() {

        /** @var FinanceParking $model */
        $model = $this->modelClass;

        $total = [];

        foreach ($model::getStatusRange() as $status) {
            $total[$status] = 0;
        }

        $items = $model::find()
            ->select(['status'])
            ->ownedBy(\Yii::$app->user->id)
            ->asArray()
            ->all();

        foreach ($items as $item) {
            ++$total[$item['status']];
        }

        $total['history'] = array_sum($total);

        return $total;
    }
}
