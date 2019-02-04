<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 31.07.17
 *
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 28.07.17
 * Time: 13:02
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models\Query;

use App\Traits\ActiveQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class ParkingLog
 * @package App\Modules\Finance\Model
 */
class FinanceParkingLog extends ActiveQuery
{
    use ActiveQueryTrait;

	/**
	 * Add parking to selection.
	 * @param int $parkingId Parking id
	 * @return ActiveQuery
	 */
	public function forParking($parkingId): ActiveQuery
	{
		$this->andWhere(compact('parkingId'));
		return $this;
	}
}