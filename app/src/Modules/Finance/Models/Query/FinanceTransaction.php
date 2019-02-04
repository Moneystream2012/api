<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date 28.07.17
 *
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 28.07.17
 * Time: 10:23
 */

namespace App\Modules\Finance\Models\Query;

use App\Traits\ActiveQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class FinanceTransaction
 * @package App\Modules\Finance\Model
 */
class FinanceTransaction extends ActiveQuery
{
    use ActiveQueryTrait;

    /**
     * @param $hashArr
     *
     * @return ActiveQuery
     */
    public function forHash($hashArr): ActiveQuery
    {
        if ($hashArr)
        {
            $this->andWhere([
                'hash' => $hashArr,
            ]);
        }

        return $this;
    }
}