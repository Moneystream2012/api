<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 06.10.17
 * Time: 18:13
 */

namespace App\Commands\Transfer\Models;


use App\Commands\Transfer\Exception\TransferException;

class BaseModel
{
    protected static $files = [
        'parking.cvs',
        'payout.cvs',
        'payout_transaction.cvs',
        'user.cvs',
        'parking_types.cvs',
        'subscriber.cvs',
    ];

    /**
     * @param array $data
     * @param array $fields
     * @return array
     */
    public function transformData(array $data, array $fields): array
    {
        $res = array_map(function ($array) use($fields) {
            $result = [];

            $items = str_getcsv($array);

            foreach ($items as $i => $item) {
                $result[$fields[$i]] = $item;
            }

            return $result;
        }, $data);

        return $res;
    }

    /**
     * @param string $file
     * @return array
     * @throws TransferException
     */
    public function getFile(string $file): array
    {
        if (!in_array($file, self::$files)) {
            throw new TransferException('No such file');
        }

        return file(__DIR__ . '/../MigrateData/' . $file);
    }

    /**
     * @param string $file
     * @param array $data
     */
    public function saveCsvFile(string $file, array $data)
    {
        $fp = fopen(__DIR__ . '/../MigrateData/' .$file, 'w');

        foreach ($data as $item) {
            if (!is_array($item)) {
                fputcsv($fp, [$item]);
            } else {
                fputcsv($fp, $item);
            }
        }

        fclose($fp);
    }
}
