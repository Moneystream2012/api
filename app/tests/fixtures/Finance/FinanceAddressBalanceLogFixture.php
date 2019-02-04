<?php
declare(strict_types=1);

namespace tests\fixtures\Finance;

use App\Modules\Database\FinanceAddressBalanceLog;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class FinanceParkingFixture
 * @package tests\fixtures\Finance
 */
class FinanceAddressBalanceLogFixture extends ActiveFixture {

    use FixtureSupport;

    /**
     * @var string
     */
    public $modelClass = FinanceAddressBalanceLog::class;


    /**
     * @return array
     */
    public function getData(): array {
        return $this->getFixturesData();
    }

    /**
     * @return array
     */
    public static function getDefaultValuesByFields(): array {
        return [
            'id'        => '',
            'addressBalanceId'    => '',
            'transactionId'    => '',
            'amount'    => '',
            'balance'      => '',
            'status'      => '',
            'createdAt'      => '',
        ];
    }
}