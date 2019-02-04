<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 *
 * Date: 17.10.17
 */
declare(strict_types=1);

namespace tests\fixtures\Explorer;

use App\Modules\Database\ExplorerInput;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class ExplorerInputFixture
 * @package tests\fixtures\Explorer
 */
class ExplorerInputFixture extends ActiveFixture
{

    use FixtureSupport;

    /**
     * @var string
     */
    public $modelClass = ExplorerInput::class;

	public $depends = [
		'tests\fixtures\Explorer\ExplorerTransactionFixture'
	];

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
			'id'            => '',
			'transactionId' => '',
			'amount'        => '',
			'address'       => '',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0010_0(): array {
		return [
			'id' => 1,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0010',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0100_0(): array {
		return [
			'id' => 2,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0100',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0101_0(): array {
		return [
			'id' => 3,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0101',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0101_1(): array {
		return [
			'id' => 4,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0101',
			'amount' => 11.055,
			'address' => 'XD6436dhgj688574b5sqLq9vxk4574HG73',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0200_0(): array {
		return [
			'id' => 5,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0200',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0200_1(): array {
		return [
			'id' => 6,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0200',
			'amount' => 20,
			'address' => 'XE3fTU4343gd653276gfHDGGRT5464gGH6',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0200_2(): array {
		return [
			'id' => 7,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0200',
			'amount' => 20.175,
			'address' => 'XC5fTU4343gd653276gfHDGGRT5464gGH6',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0201_0(): array {
		return [
			'id' => 8,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0201',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0201_1(): array {
		return [
			'id' => 9,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0201',
			'amount' => 0.45,
			'address' => 'XEDF16KSbz286khHb5sqLq9vxk1t7FUtGk',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0202_0(): array {
		return [
			'id' => 10,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0202',
			'amount' => 0.745,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0203_0(): array {
		return [
			'id' => 11,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0203',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0300_0(): array {
		return [
			'id' => 12,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0300',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0301_0(): array {
		return [
			'id' => 13,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0301',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0302_0(): array {
		return [
			'id' => 14,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0302',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0302_1(): array {
		return [
			'id' => 15,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0302',
			'amount' => 12.0,
			'address' => 'X4543sHCQkECjXDKkC1QjCQoZj7kj3KwqB',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0302_2(): array {
		return [
			'id' => 16,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0302',
			'amount' => 14.0,
			'address' => 'X86656KSbz2864387fjfjgd84768768gfj',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0302_3(): array {
		return [
			'id' => 17,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0302',
			'amount' => 16.0,
			'address' => 'Xd46567343gd653276gfHDGGRT5464gGH6',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0302_4(): array {
		return [
			'id' => 18,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0302',
			'amount' => 18.0,
			'address' => 'Xa2356dhgj688574b5sqLq9vxk4574HG73',
		];
	}

	/**
	 * @return array
	 */
	public function itemInput_0400_0(): array {
		return [
			'id' => 19,
			'transactionId' => '123456abcdef123456abcdef123456abcdef123456abcdef123456abcdef0400',
			'amount' => 2.5,
			'address' => 'coinbase',
		];
	}

}