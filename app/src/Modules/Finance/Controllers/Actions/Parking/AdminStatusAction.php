<?php
/**
 * @author Tarasenko Andrii
 * @date: 30.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers\Actions\Parking;

use App\Modules\Finance\Models\FinanceParking;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\IndexAction;

/**
 * Class StatusAction
 * @package App\Modules\Finance\Controllers\Actions\Parking
 */
class AdminStatusAction extends IndexAction
{
    protected function prepareDataProvider()
    {
        $status = Yii::$app->request->get('status');

        if (!empty($status)) {
            $search = explode(',', $status);
        }

        /* @var $modelClass FinanceParking*/
        $modelClass = $this->modelClass;

        return Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => !empty($status)
                        ? $modelClass::find()->whereStatus($search)
                        : $modelClass::find(),
        ]);
    }

}
