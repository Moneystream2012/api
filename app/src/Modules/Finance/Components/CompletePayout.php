<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date 09.08.17
 */
declare(strict_types=1);

namespace App\Modules\Finance\Components;

use Yii;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\validators\{StringValidator, RegularExpressionValidator};
use App\Modules\Finance\Models\{FinanceTransaction, FinanceTransactionLog};

/**
 * Class CompleteAction
 * @package App\Modules\Finance\Controllers\Actions\Transaction
 *
 * @api {get} log/:id Get logs of parking
 * @apiVersion 1.0.0
 * @apiName GetTransactionComplete
 * @apiGroup TransactionComplete
 *
 * @apiParam {Integer} id Id of parking.
 *
 * @apiSuccess {Array} Response List of Object(s).
 * @apiSuccess {String} Object.status Status of parking.
 * @apiSuccess {String} Object.createdAt Date and time of log creation.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     [
 *          {
 *              "status": "active",
 *              "createdAt": "2017-07-31 12:39:40"
 *          }
 *     ]
 *
 * @apiUse NotFoundError
 * @apiUse UnavailableError
 * @apiUse UnauthorisedError
 */
class CompletePayout extends Object
{
    const CATEGORY = "finance_complete_payouts";

    /**
     * @var StringValidator $validator
     */
    public $validator;

    /**
     * @var RegularExpressionValidator $matchValidator
     */
    public $matchValidator;


    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->validator = new StringValidator(['min' => 28, 'max' => 35]);
        $this->matchValidator = new RegularExpressionValidator(['pattern' => '/^[a-fA-F0-9_-]+$/']);
    }

	/**
	 * @inheritdoc
	 */
	public function proceed(array $hashCompleted): array
	{
        $hashCompleted = array_unique($hashCompleted);

        $hashArr = array_filter(
            $hashCompleted,
            function ($hash) {return $this->validateHash($hash);}
        );

        $transactionIds = [];

        if (!empty($hashArr))
        {
            $transactions = FinanceTransaction::find()
                ->select(['id', 'hash', 'createdAt'])
                ->forHash($hashArr)
                ->orderedByCreation(SORT_ASC)
                ->asArray()
                ->all();

            Yii::info('$hashArr: '. Json::encode($hashArr));
            Yii::info('$transactions: '. Json::encode($transactions));

            $transactionIds = ArrayHelper::getColumn($transactions, 'id');

            $logs = array_map(
                function ($transactionId) {
                    return [
                        $transactionId,
                        FinanceTransactionLog::TYPE_COMPLETED,
                        Yii::$app->formatter->asDatetime(time()),
                    ];
                },
                $transactionIds
            );

            $dbTransaction = Yii::$app->db->beginTransaction();

            Yii::info('transaction ids:');
            Yii::info(Json::encode($transactionIds));

            $count = FinanceTransaction::updateAll(
                ['status' => FinanceTransaction::TYPE_COMPLETED],
                ['id' => $transactionIds]
            );

            $logCount = Yii::$app->db->createCommand()->batchInsert(
                FinanceTransactionLog::tableName(),
                ['transactionId', 'status', 'createdAt'],
                $logs
            )->execute();

            if ($logCount < $count)
            {
                Yii::warning("Problem saving to transaction log " . __FILE__ . " line " . __LINE__,
                    static::CATEGORY);
            }

            $dbTransaction->commit();
        }

        return $transactionIds;
	}

    /**
     * @param $hash
     *
     * @return bool
     */
    private function validateHash($hash): bool
    {
        return true; //$this->validator->validate($hash) && $this->matchValidator->validate($hash);
    }
}