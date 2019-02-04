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

namespace App\Modules\Notification\Models\Query;

use yii\mongodb\ActiveQuery;
use yii;

class Notification extends ActiveQuery
{
    /**
     * @param $userId
     * @param $seen
     *
     * @return ActiveQuery
     */
    public function seenBy($userId, $seen = null): ActiveQuery {

        if ($seen === true || $seen === 'true') {

            $this->andWhere(['seenBy' => ['$in' => [$userId]]]);

        } elseif ($seen === false || $seen === 'false') {

            $this->andWhere(['seenBy' => ['$nin' => [$userId]]]);
        }

        return $this;
    }

    /**
     * @param $userId
     *
     * @return ActiveQuery
     */
    public function postedFor($userId): ActiveQuery {
        $this->andWhere([
            'OR',
            ['postedFor' => $userId],
            ['postedFor' => ['$size' => 0]]
        ]);

        return $this;
    }
}