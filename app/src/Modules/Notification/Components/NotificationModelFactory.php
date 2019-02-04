<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Notification\Components;

use App\{
    Components\BaseModelFactory,
    Modules\Notification\Models\Notification
};

/**
 * Class NotificationModelFactory
 * @package App\Modules\Notification\Components
 */
class NotificationModelFactory extends BaseModelFactory
{
	public const NOTIFICATION = 'notification';

	/**
	 * Method which populates @var $models
	 */
	protected static function populateModels(): void
	{
		static::$models = [
			static::NOTIFICATION => Notification::class,
		];
	}
}