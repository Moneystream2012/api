<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 *
 * Date: 17.10.17
 */

namespace tests\fixtures\Mail;

use App\Modules\Database\MailTemplate;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class MailTemplateFixture
 * @package tests\fixtures\Mail
 */
class MailTemplateFixture extends ActiveFixture
{

	use FixtureSupport;

	/**
	 * @var string
	 */
	public $modelClass = MailTemplate::class;

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
			'id'          => '',
			'name'        => '',
			'content'     => '',
			'createdAt'   => '',
			'updatedAt'   => '',
			'authorId'    => '',
			'moderatorId' => '',
		];
	}

	/**
	 * @return array
	 */
	public function itemFirstTemplate():array  {
		return [
			'id'          => '1',
			'name'        => 'First Template',
			'content'     => 'Hello from First Template',
			'createdAt'   => '2017-10-24 11:37:15',
			'updatedAt'   => '2017-10-24 12:39:45',
			'authorId'    => 1,
			'moderatorId' => 1,
		];
	}

	/**
	 * @return array
	 */
	public function itemSecondTemplate():array  {
		return [
			'id'          => '2',
			'name'        => 'Second Template',
			'content'     => 'Hello from Second Template',
			'createdAt'   => '2017-10-24 11:37:15',
			'updatedAt'   => '2017-10-24 12:39:45',
			'authorId'    => 1,
			'moderatorId' => 1,
		];
	}

}