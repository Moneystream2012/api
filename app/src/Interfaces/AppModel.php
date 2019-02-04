<?php
/**
 * @author Tarasenko Andrii
 * @date: 12.07.17
 */

declare(strict_types=1);

namespace App\Interfaces;

use IteratorAggregate;
use ArrayAccess;
use yii\db\ActiveRecordInterface;
use yii\base\{Arrayable, Configurable};

/**
 * Interface AppModel
 * @package App\Interfaces
 */
interface AppModel extends Configurable, IteratorAggregate, ArrayAccess, Arrayable, ActiveRecordInterface
{

}
