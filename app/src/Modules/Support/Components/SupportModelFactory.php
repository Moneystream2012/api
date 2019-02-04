<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support\Components;

use App\Components\BaseModelFactory;
use App\Modules\Support\Models\{
	SupportAvatar, SupportMessage, SupportMessageAttachment
};

/**
 * Class SupportModelFactory
 * @package App\Modules\Support\Components
 */
class SupportModelFactory extends BaseModelFactory
{
	public const AVATAR = 'avatar';
	public const MESSAGE = 'message';
	public const MESSAGE_ATTACHMENT = 'messageAttachment';

	/**
	 * Method which populates @var $models
	 */
	protected static function populateModels(): void
	{
		static::$models = [
			static::AVATAR => SupportAvatar::class,
			static::MESSAGE => SupportMessage::class,
			static::MESSAGE_ATTACHMENT => SupportMessageAttachment::class
		];
	}
}