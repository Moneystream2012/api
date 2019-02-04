<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Components;

use App\Components\BaseModelFactory;
use App\Modules\Subscribe\Models\{
	Subscriber,
	SubscriberGroup,
	SubscribeMessage,
	SubscriberAndGroup,
	SubscribeSource
};

/**
 * Class SubscribeModelFactory
 * @package App\Modules\Subscribe\Components
 */
class SubscribeModelFactory extends BaseModelFactory
{
	public const SUBSCRIBER = 'subscriber';
	public const SUBSCRIBER_GROUP = 'subscriberGroup';
	public const MESSAGE = 'subscribeMessage';
	public const SUBSCRIBER_AND_GROUP = 'subscriberAndGroup';
	public const SOURCE = 'subscribeSource';

	/**
	 * Method which populates @var $models
	 */
	protected static function populateModels(): void
	{
		static::$models = [
			static::SUBSCRIBER => Subscriber::class,
			static::SUBSCRIBER_GROUP => SubscriberGroup::class,
			static::MESSAGE => SubscribeMessage::class,
			static::SUBSCRIBER_AND_GROUP => SubscriberAndGroup::class,
			static::SOURCE => SubscribeSource::class
		];
	}
}