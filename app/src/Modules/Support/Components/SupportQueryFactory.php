<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 27.07.17
 *
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 28.07.17
 * Time: 11:21
 */
declare(strict_types=1);

namespace App\Modules\Support\Components;

use App\Components\BaseQueryFactory;
use App\Modules\Support\Models\{
	Query\Avatar, Query\Message
};

/**
 * Class SupportQueryFactory
 * @package App\Modules\Support\Components
 */
class SupportQueryFactory extends BaseQueryFactory
{
	public const AVATAR = 'avatar';
	public const MESSAGE = 'message';

	/**
	 * Method which populates @var $models
	 */
	protected static function populateModels(): void
	{
		static::$models = [
			static::AVATAR => Avatar::class,
			static::MESSAGE => Message::class
		];
	}
}