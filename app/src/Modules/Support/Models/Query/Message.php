<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 28.07.17
 * 
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 28.07.17
 * Time: 10:23
 */

namespace App\Modules\Support\Models\Query;

use yii\db\ActiveQuery;

class Message extends ActiveQuery
{
	/**
	 * Set right order.
	 *
	 * @return ActiveQuery
	 */
	public function orderedByCreation($asc = SORT_ASC): ActiveQuery
	{
		$this->orderBy(['createdAt'=>$asc]);
		return $this;
	}
}