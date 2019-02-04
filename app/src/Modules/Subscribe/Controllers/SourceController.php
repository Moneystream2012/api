<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Controllers;

use App\{
	Components\RestController,
	Modules\Subscribe\Components\SubscribeModelFactory
};
use yii\filters\AccessControl;

/**
 * Class SourceController
 * @package App\Modules\Subscribe\Controllers
 */
class SourceController extends RestController
{
	public $modelClass;

	/**
	 * Init model class.
	 */
	public function init(): void
	{
		$this->modelClass = SubscribeModelFactory::getClass(SubscribeModelFactory::SOURCE);
	}

    /**
     * Behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access']  = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['user'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return parent::verbs();
    }

    /**
     * @api {post} subscribe/source Create subscribeSource
     * @apiVersion 1.0.0
     * @apiName CreateSubscribeSource
     * @apiGroup SubscribeSource
     *
     * @apiDescription Create new subscribeSource object.
     *
     * @apiParam {String} name SubscribeSource's name.
     *
     * @apiSuccess {Integer} id SubscribeSource's id.
     * @apiSuccess {String} name SubscribeSource's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Base source"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscribe/source Get list of subscribeSources
     * @apiVersion 1.0.0
     * @apiName GetSubscribeSources
     * @apiGroup SubscribeSource
     *
     * @apiDescription Get list of subscribeSources.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SubscribeSource's id.
     * @apiSuccess {String} Object.name SubscribeSource's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "name": "Base source"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} subscribe/source/:id Get subscribeSource object
     * @apiVersion 1.0.0
     * @apiName GetSubscribeSource
     * @apiGroup SubscribeSource
     *
     * @apiDescription Get object of subscribeSource.
     *
     * @apiParam {Integer} id Identifier of subscribeSource object.
     *
     * @apiSuccess {Integer} id SubscribeSource's id.
     * @apiSuccess {String} name SubscribeSource's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Base source"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} subscribe/source/:id Update subscribeSource object
     * @apiVersion 1.0.0
     * @apiName UpdateSubscribeSource
     * @apiGroup SubscribeSource
     *
     * @apiDescription Update object of subscribeSource.
     *
     * @apiParam {Integer} id Identifier of subscribeSource object.
     *
     * @apiParam {String} name SubscribeSource's name.
     *
     * @apiSuccess {Integer} id SubscribeSource's id.
     * @apiSuccess {String} name SubscribeSource's name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Base source"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} subscribe/source/:id Delete subscribeSource object
     * @apiVersion 1.0.0
     * @apiName DeleteSubscribeSource
     * @apiGroup SubscribeSource
     *
     * @apiDescription Delete object of subscribeSource.
     *
     * @apiParam {Integer} id Identifier of subscribeSource object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
