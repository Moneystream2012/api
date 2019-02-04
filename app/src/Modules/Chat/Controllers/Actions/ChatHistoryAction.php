<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 19.10.17
 * Time: 18:17
 */

namespace App\Modules\Chat\Controllers\Actions;


use yii\rest\Action;
use Yii;

class ChatHistoryAction extends Action
{
    /**
     * @return mixed
     */
    public function run()
    {
        $page = (int)Yii::$app->request->get('page', 1);
        return \Yii::$app->liveChat->getHistory($page);
    }
}
