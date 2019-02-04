<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 13.11.17
 * Time: 15:39
 */

namespace App\Components;
use Yii;


class LocalMinexnode extends Minexnode
{
    /**
     * @return Rpc
     */
    public function getServer(): Rpc
    {
        if (empty($this->rpc)) {
            $this->rpc = Yii::$app->localRpc;
        }

        return $this->rpc;
    }
}
