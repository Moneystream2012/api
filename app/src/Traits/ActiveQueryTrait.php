<?php
/**
 * @author Tarasenko Andrii
 * @date: 29.08.17
 */

declare(strict_types=1);

namespace App\Traits;

use yii\db\ActiveQuery;

/**
 * Trait ActiveQueryTrait
 * @package App\Traits
 */
trait ActiveQueryTrait
{
    /**
     * Add owner condition to select.
     *
     * @param int $userId User's id
     *
     * @return ActiveQuery
     */
    public function ownedBy($userId): ActiveQuery
    {
        $this->andWhere(compact('userId'));
        return $this;
    }

    /**
     * @param $status
     *
     * @return ActiveQuery
     */
    public function whereStatus($status): ActiveQuery
    {
        $this->andWhere(['status' => $status]);
        return $this;
    }

    /**
     * Add ordering.
     *
     * @param int $order
     * @return ActiveQuery
     */
    public function orderedByCreation($order = SORT_ASC): ActiveQuery
    {
        $this->orderBy(['createdAt'=>$order]);
        return $this;
    }
}
