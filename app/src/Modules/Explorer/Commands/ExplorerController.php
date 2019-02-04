<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 11:27
 */
declare(strict_types=1);

namespace App\Modules\Explorer\Commands;

use App\Components\Minexnode;
use App\Modules\Explorer\Commands\Actions\Explorer\SyncAction;
use App\Modules\Explorer\Components\ExplorerModelFactory;
use yii\console\Controller;

/**
 * {@inheritDoc}
 */
class ExplorerController extends Controller
{
    public function actions()
    {
        return [
            'sync' => [
                'class' => SyncAction::class,
            ]
        ];
    }


}