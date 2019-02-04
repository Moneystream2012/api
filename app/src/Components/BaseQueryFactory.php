<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 28.07.17
 */

declare(strict_types=1);

namespace App\Components;

use App\{
    Exceptions\ModelFactoryException, Interfaces\Factory
};
use yii\db\ActiveQuery;

/**
 * Class BaseQueryFactory
 * @package App\Components
 */
abstract class BaseQueryFactory implements Factory
{
	/**
	 * @var array
	 */
	protected static $models = [];

	/**
	 * @param string $name
	 * @param array $config
	 * @return ActiveQuery
	 */
	public static function create(string $name, $config = null): ActiveQuery
	{
		static::populateModels();
		static::isNameExist($name);

		return new static::$models[$name]($config);
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public static function getClass(string $name): string
	{
		static::populateModels();
		static::isNameExist($name);

		return static::$models[$name];
	}

	/**
	 * Method which populates @var $models
	 */
	protected abstract static function populateModels(): void;

	/**
	 * @param string $name
	 * @throws ModelFactoryException
	 */
	protected static function isNameExist(string $name): void {
		if (empty(static::$models[$name])) {
			throw new ModelFactoryException('Short name not found! Is it typing mistace? You search for: '. $name );
		}
	}
}