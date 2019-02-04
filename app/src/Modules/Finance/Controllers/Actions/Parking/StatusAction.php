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
class StatusAction extends IndexAction
{
	protected function prepareDataProvider(): ActiveDataProvider {
        $status = Yii::$app->request->get('status');

        if (!empty($status)) {
            $search = explode(',', $status);
        }

        /* @var $modelClass FinanceParking*/
        $modelClass = $this->modelClass;

        if(!empty($status)) {
        	$query = $modelClass::find()
		        ->whereStatus($search)
		        ->ownedBy(\Yii::$app->user->id)
		        ->orderedByCreation(SORT_DESC)
		        ->with(['type']);
        } else {
	        $query = $modelClass::find()
		        ->ownedBy(\Yii::$app->user->id)
		        ->orderedByCreation(SORT_DESC)
		        ->with(['type']);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
	}

}
