<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 28.07.17
 *
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 28.07.17
 * Time: 10:00
 */
declare(strict_types=1);

namespace App\Modules\Support\Models\Query;
use yii\db\ActiveQuery;

/**
 * Class AvatarQuery
 * @package App\Modules\Support\Model
 */
class Avatar extends ActiveQuery
{
	/**
	 * Add condition for owner.
	 *
	 * @param int $id User's id
	 * @return ActiveQuery
	 */
	public function ownedBy($id): ActiveQuery
	{
		$this->andWhere(['userId'=>$id]);
		return $this;
	}
}