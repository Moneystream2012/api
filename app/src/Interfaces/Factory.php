<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 28.07.17
 */

declare(strict_types=1);

namespace App\Interfaces;

/**
 * Interface QueryFactory
 * @package App\Interfaces
 */
interface Factory
{
	public static function create(string $name, $config);

	public static function getClass(string $name): string;
}