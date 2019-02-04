<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * Date: 05.10.17
 */

declare(strict_types=1);

namespace tests\_support;

use \Codeception\Util\HttpCode;

/**
 * Class RoleCest
 * @package tests\_support
 */
trait RoleCest
{
    /**
     * @param \Codeception\Example|array $example
     * @param string $default
     * @param int $code
     *
     * @return array [dataForTest, string|string[] Role]
     */
    private function getTestRoleData($example, $code = HttpCode::FORBIDDEN, $default = "user"): array {
        if (!is_array($example)) {
            $example = $example->getIterator()->getArrayCopy();
        }

        if (array_key_exists("role", $example)) {
            $minimalRole = $example["role"];
            unset($example["role"]);
        } else {
            $minimalRole = $default;
        }

        return [$example, $this->getTestedRoles($minimalRole, $code)];
    }

    /**
     * @param string $minimalRole
     * @param int $code
     *
     * @return array|mixed
     */
    private function getTestedRoles(string $minimalRole, int $code) {
        if ($code === HttpCode::FORBIDDEN) {
            return $this->failRoles($minimalRole);
        } else {
            $roles = $this->successRoles($minimalRole);
            return array_shift($roles);
        }
    }

    /**
     * @param string $minimalRole
     *
     * @return array
     */
    private function successRoles(string $minimalRole): array {
    	if (strpos($minimalRole, "^") === 0) {
		    return [substr($minimalRole, 1)];
	    }

        switch ($minimalRole) {
            case 'admin':
                return ['admin'];
            case 'support':
                return ['support', 'admin'];
            default:
                return ['user', 'support', 'admin'];
        }
    }

    /**
     * @param string $minimalRole
     *
     * @return array
     */
    private function failRoles(string $minimalRole): array {
	    if (strpos($minimalRole, "^") === 0) {
		    return [substr($minimalRole, 1)];
	    }

        switch ($minimalRole) {
            case 'admin':
                return ['user', 'support'];
            case 'support':
                return ['user'];
            default:
                return [];
        }
    }
}