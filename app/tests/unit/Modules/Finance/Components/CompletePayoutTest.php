<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 20.10.17
 * Time: 15:11
 */
declare(strict_types=1);

namespace tests\unit\Modules\Finance\Components;

use App\Modules\Finance\Components\CompletePayout;
use tests\fixtures\Finance\FinanceTransactionFixture;
use tests\unit\BaseTestCase;

/**
 * Class CompletePayout
 * @package tests\unit\Modules\Finance\Components
 */
class CompletePayoutTest extends BaseTestCase
{

	/**
	 * @var string
	 */
	public $testedClass = CompletePayout::class;

	/**
	 * @return array
	 */
	public function _fixtures() {
		return [
			FinanceTransactionFixture::class
		];
	}

	public function testProceed() {

	}
}