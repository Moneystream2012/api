<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Controllers;

use App\{
    Components\RestController, Modules\Finance\Components\FinanceModelFactory, Helpers\Arr, Modules\Finance\Controllers\Actions\Transaction\FilterAction, Modules\Finance\Controllers\Actions\Transaction\AdminFilterAction, Modules\Finance\Controllers\Actions\Transaction\LastAction
};
use yii\filters\AccessControl;


/**
 * Class TransactionController
 * @package App\Modules\Finance\Controllers
 */
class TransactionController extends RestController
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->modelClass = FinanceModelFactory::getClass(FinanceModelFactory::TRANSACTION);
    }

    /**
     * Behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

//        $behaviors['access']  = [
//            'class' => AccessControl::className(),
//            'except' => ['options'],
//            'rules' => [
//                [
//                    'allow' => true,
//                    'actions' => ['admin-filter'],
//                    'roles' => ['admin'],
//                ],
//                [
//                    'allow' => true,
//                    'actions' => ['filter'],
//                    'roles' => ['user'],
//                ],
//                [
//                    'allow' => true,
//                    'actions' => ['last'],
//                ]
//            ],
//        ];

        return $behaviors;
    }

    protected function verbs(): array
    {
        return [
            'admin-filter' => ['GET'],
            'filter' => ['GET'],
            'last' => ['GET'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $actions = [
            'admin-filter' => [
                'class' => AdminFilterAction::class,
                'modelClass' => $this->modelClass
            ],
            'filter' => [
                'class' => FilterAction::class,
                'modelClass' => $this->modelClass
            ],
            'last' => [
                'class' => LastAction::class,
                'modelClass' => $this->modelClass
            ]
        ];

        return Arr::merge(
            Arr::removeSeveral(parent::actions(), ['index', 'create', 'view', 'update', 'delete']),
            $actions
        );
    }

    /**
     * @api {post} transaction Create transaction
     * @apiVersion 1.0.0
     * @apiName CreateTransaction
     * @apiGroup Transaction
     *
     * @apiDescription Create new transaction object.
     *
     * @apiParam {String} hash Transaction's hash.
     * @apiParam {Integer} parkingId Transaction's parking id.
     * @apiParam {Integer} amount Transaction's amount.
     * @apiParam {Integer} fee Transaction's fee.
     * @apiParam {String=pending,completed,canceled} status Transaction's status.
     *
     * @apiSuccess {Integer} id Transaction's id.
     * @apiSuccess {String} hash Transaction's hash.
     * @apiSuccess {Integer} parkingId Transaction's parking id.
     * @apiSuccess {Integer} amount Transaction's amount.
     * @apiSuccess {Integer} fee Transaction's fee.
     * @apiSuccess {String} status Transaction's status.
     * @apiSuccess {String} createdAt Transaction's created at datetime.
     * @apiSuccess {String} updatedAt Transaction's updated at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "hash": "1114435364565464646454554636446565465456457437763365466546112593",
     *          "parkingId": 1,
     *          "amount": 240000,
     *          "fee": 500,
     *          "status": "pending",
     *          "createdAt": "2017-08-24 11:37:15",
     *          "updatedAt": "2017-08-27 15:12:33"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} transaction Get list of transactions
     * @apiVersion 1.0.0
     * @apiName GetTransactions
     * @apiGroup Transaction
     *
     * @apiDescription Get list of transactions.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id Transaction's id.
     * @apiSuccess {String} Object.hash Transaction's hash.
     * @apiSuccess {Integer} Object.parkingId Transaction's parking id.
     * @apiSuccess {Integer} Object.amount Transaction's amount.
     * @apiSuccess {Integer} Object.fee Transaction's fee.
     * @apiSuccess {String=pending,completed,canceled} Object.status Transaction's status.
     * @apiSuccess {String} Object.createdAt Transaction's created at datetime.
     * @apiSuccess {String} Object.updatedAt Transaction's updated at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "hash": "1114435364565464646454554636446565465456457437763365466546112593",
     *              "parkingId": 1,
     *              "amount": 240000,
     *              "fee": 500,
     *              "status": "pending",
     *              "createdAt": "2017-08-24 11:37:15",
     *              "updatedAt": "2017-08-27 15:12:33"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} transaction/:id Get transaction object
     * @apiVersion 1.0.0
     * @apiName GetTransaction
     * @apiGroup Transaction
     *
     * @apiDescription Get object of transaction.
     *
     * @apiParam {Integer} id Identifier of transaction object.
     *
     * @apiSuccess {Integer} id Transaction's id.
     * @apiSuccess {String} hash Transaction's hash.
     * @apiSuccess {Integer} parkingId Transaction's parking id.
     * @apiSuccess {Integer} amount Transaction's amount.
     * @apiSuccess {Integer} fee Transaction's fee.
     * @apiSuccess {String=pending,completed,canceled} status Transaction's status.
     * @apiSuccess {String} createdAt Transaction's created at datetime.
     * @apiSuccess {String} updatedAt Transaction's updated at datetime.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "hash": "1114435364565464646454554636446565465456457437763365466546112593",
     *          "parkingId": 1,
     *          "amount": 240000,
     *          "fee": 500,
     *          "status": "pending",
     *          "createdAt": "2017-08-24 11:37:15",
     *          "updatedAt": "2017-08-27 15:12:33"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} transaction/:id Delete transaction object
     * @apiVersion 1.0.0
     * @apiName DeleteTransaction
     * @apiGroup Transaction
     *
     * @apiDescription Delete object of transaction.
     *
     * @apiParam {Integer} id Identifier of transaction object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
