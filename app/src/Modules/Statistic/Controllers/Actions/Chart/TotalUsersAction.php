<?php
/**
 * @author Aleksey Kucherov <alex.rgb.kiev@gmail.com>
 * @date: 21.09.17
 */

declare(strict_types=1);

namespace App\Modules\Statistic\Controllers\Actions\Chart;


use App\Modules\User\Components\UserModelFactory;
use yii\rest\Action;

/**
 * Class TotalUsersAction
 * @package App\Modules\Statistic\Controllers\Actions\Action
 */
class TotalUsersAction extends Action
{

    /**
     * @return array
     */
    public function run() {

        /** @var \App\Modules\User\Models\User $userModel */
        $userModel = UserModelFactory::getClass(UserModelFactory::USER);

        $result = $userModel::find()
            ->selectGroupByCreatedAt()
            ->asArray()
            ->all();

        return [
            'name' => 'TotalUsers',
            'series' => $result
        ];
    }
}