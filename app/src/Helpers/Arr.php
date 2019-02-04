<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 17.07.17
 * Time: 17:30
 */

namespace App\Helpers;

use yii\helpers\ArrayHelper;

/**
 * Class Arr
 * @package App\Helpers
 * Alias class!
 */
class Arr extends ArrayHelper
{

    /**
     * @param array $array
     * @param array $keys
     * @param bool $caseSensitive
     * @return bool
     */
    public static function keysExsists(array $array, array $keys, bool $caseSensitive = true): bool {
        foreach ($keys as $key) {
            if (!self::keyExists($key, $array, $caseSensitive)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function removeSeveral(array $array, array $keys): array {
        foreach ($keys as $key) {
            self::remove($array, $key);
        }

        return $array;
    }

    /**
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function removeSeveralAssoc(array $array, $key): array {
        foreach ($array as &$item) {
            if(is_array($key)) {
                foreach ($key as $remover) {
                    self::remove($item, $remover);
                }
            } else {
                self::remove($item, $key);
            }
        }

        return $array;
    }
}
