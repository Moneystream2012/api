<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Components\RestController;
use App\Modules\Mail\{
    Components\MailModelFactory,
    Controllers\Actions\Mail\SendAction
};
use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Class SiteController
 * @package App\Controllers
 */
class SiteController extends Controller
{
    public function actionIndex(){
        echo 'index';
        return 'index';
    }
}
