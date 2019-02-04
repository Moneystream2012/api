<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 08.10.17
 * Time: 12:55
 */

namespace App\Commands\Transfer\Models;


class ParkingProxy
{
    private static $instance = null;

    private $ids = [];

    /**
     * @return ParkingProxy
     */
    public static function getInstance(): ParkingProxy
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
