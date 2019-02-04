<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date 14.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models\Query;

use App\Traits\ActiveQueryTrait;
use Yii;
use yii\db\ActiveQuery;
use App\Modules\Finance\Models\FinanceParking as FinanceParkingModel;
use yii\db\Expression;

/**
 * Class FinanceParking
 * @package App\Modules\Finance\Model
 */
class FinanceParking extends ActiveQuery
{
	use ActiveQueryTrait;

    /**
     * Select only needed fields with DISTINCT(`userId`).
     *
     * @return FinanceParking
     */
	public function selectDistinctUserId(): FinanceParking {
        $this->select([
            'DISTINCT(`userId`)',
            'id',
            'rate',
            'typeId',
            'amount',
            'status'
        ]);

        $this->groupBy(['userId']);
		return $this;
	}

    /**
     * @return ActiveQuery
     */
	public function whereOrderedElapsed(): ActiveQuery {
        $elapsed = "DATE_ADD(createdAt, INTERVAL `period` SECOND)";

        $this->andWhere(['<', $elapsed, Yii::$app->formatter->asDatetime(time())]);
        $this->orderBy($elapsed);
        return $this;
	}

	/**
	 * @param array $status
	 * @return FinanceParking
	 */
	public function filterStatus(array $status): FinanceParking {
	    $this->andWhere(['status' => $status]);
	    return $this;
	}

	/**
	 * @param $typeId
	 * @return ActiveQuery
	 */
	public function typeIs($typeId): ActiveQuery {
		$this->andWhere(['typeId' => $typeId]);
		return $this;
	}

	/**
	 * @param int $min
	 * @param int $max
	 * @return ActiveQuery
	 */
	public function createAtBetween(int $min, int $max) : ActiveQuery {
		$this->andWhere([
			'between',
			'createdAt',
			Yii::$app->formatter->asDatetime($min),
			Yii::$app->formatter->asDatetime($max),
		]);
		return $this;
	}

	/**
	 * @param int $userId
	 * @return ActiveQuery
	 */
	public function ownedBy($userId): ActiveQuery {
		$this->andWhere(['userId' => $userId]);
		return $this;
	}


    /**
     * @param array $search
     * @return FinanceParking
     */
    public function search(array $search): FinanceParking {
	    $filter = array_map(function ($item) {

	        return [
	            'and',
                ['typeId' => $item['typeId']],
                ['<=', 'createdAt', $item['date']]
            ];
        }, $search);

        array_unshift($filter, 'or');

	    $this->andWhere($filter);

        return $this;
    }

    public function byType($id)
    {
        $this->where([
            'typeId' => $id
        ]);

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function activeParking(): ActiveQuery
    {
        $this->andWhere([
            'status' => [FinanceParkingModel::TYPE_ACTIVE, FinanceParkingModel::TYPE_PENDING],
        ]);

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function groupByDays(): ActiveQuery
    {
        $this->groupBy(new Expression('YEAR(createdAt), MONTH(createdAt), DAY(createdAt)'));
        return $this;
    }
}