<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Components;

use App\Components\BaseModelFactory;
use App\Modules\Finance\Models\{
    FinanceParking, FinanceParkingLog, FinanceParkingStatisticAbstract, FinanceParkingType, FinanceTransaction, FinanceTransactionLog, FinanceAddressBalance, FinanceAddressBalanceLog, FinancePayoutSource
};

/**
 * Class FinanceModelFactory
 * @package App\Modules\Finance\Components
 */
class FinanceModelFactory extends BaseModelFactory
{
    public const PARKING = 'parking';
    public const PARKING_LOG = 'parkingLog';
    public const PARKING_TYPE = 'parkingType';
    public const TRANSACTION = 'transaction';
    public const TRANSACTION_LOG = 'transactionLog';
    public const ADDRESS_BALANCE = 'addressBalance';
    public const ADDRESS_BALANCE_LOG = 'addressBalanceLog';
    public const PAYOUT_SOURCE = 'payoutSource';


    /**
     * Method which populates @var $models
     */
	protected static function populateModels(): void {
        static::$models = [
            static::PARKING => FinanceParking::class,
            static::PARKING_LOG => FinanceParkingLog::class,
            static::PARKING_TYPE => FinanceParkingType::class,
            static::TRANSACTION => FinanceTransaction::class,
            static::TRANSACTION_LOG => FinanceTransactionLog::class,
            static::ADDRESS_BALANCE => FinanceAddressBalance::class,
            static::ADDRESS_BALANCE_LOG => FinanceAddressBalanceLog::class,
            static::PAYOUT_SOURCE => FinancePayoutSource::class,
        ];
	}
}