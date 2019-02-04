<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 23.10.17
 * Time: 16:25
 */

namespace App\Commands\Transfer\Models;


class UserProxy
{
    private static $instance = null;

    private $ids = [];

    /**
     * @return UserProxy
     */
    public static function getInstance(): UserProxy
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function saveId(int $oldId, int $newId)
    {
        $this->ids[$oldId] = $newId;
    }

    public function getId(int $oldId): ?int
    {
        if (isset($this->ids[$oldId])) {
            return $this->ids[$oldId];
        }

        return null;
    }
}
