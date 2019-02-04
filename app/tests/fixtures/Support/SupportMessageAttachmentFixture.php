<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 17.08.17
 * Time: 11:06
 */
declare(strict_types=1);

namespace tests\fixtures\Support;

use App\Modules\Database\SupportMessageAttachment;
use tests\_support\fixtures\FixtureSupport;
use yii\test\ActiveFixture;

/**
 * Class SupportMessageAttachmentFixture
 * @package tests\fixtures\Support
 */
class SupportMessageAttachmentFixture extends ActiveFixture
{
	use FixtureSupport;

	public $modelClass = SupportMessageAttachment::class;

	public $depends = [SupportMessageFixture::class];

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
			//'id'        => '',
			'messageId' => '',
			'type'      => '',
			'filename'  => '',
			'createdAt' => ''
		];
	}

	public function itemRootUser() {
		return [
			'id'        => '1',
			'messageId' => '1',
			'type'      => 'image',
			'filename'  => 'foo.jpg',
			'createdAt' => '2017-08-18 07:28:02'
		];
	}
}