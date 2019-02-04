<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 30.08.17
 * Time: 17:45
 */

namespace App\Interfaces;


interface Editable
{
	/**
	 * Get owner id
	 *
	 * @return integer
	 */
	public function getUserId();
}
