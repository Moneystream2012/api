<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 28.07.17
 * Time: 16:13
 */

namespace App\Modules\User\Models\Query;

use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package Modules\User\Model\Query
 */
class UserQuery extends ActiveQuery
{

    /**
     * @return self
     */
    public function selectGroupByCreatedAt() {

        $this
            ->addSelect('COUNT(`id`) as value')
            ->addSelect('DATE(`createdAt`) as name')
        ->groupBy('DATE(`createdAt`)');

        return $this;
    }
}
