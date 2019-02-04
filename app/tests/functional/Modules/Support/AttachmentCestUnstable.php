<?php
/**
 *  * @author Andru Cherny <acherny@minexsystems.com>
 * Date: 15.08.17
 * Time: 12:45
 */
declare(strict_types=1);

namespace tests\functional\Modules\Support;

use tests\_support\RestCest;
use tests\fixtures\Support\SupportMessageAttachmentFixture;

/**
 * Class AvatarCest
 * @package tests\functional\Modules\Support
 */
class AttachmentCestUnstable
{

	use RestCest;

	/**
	 * @return array
	 */
	public function _fixtures(): array
    {
		return [SupportMessageAttachmentFixture::class];
	}
	/**
	 *
	 */

	public $url = 'support/message-attachment';


	/**
	 * @return array
	 */
	protected function create(): array
    {
		return [
			'data'     => [
				'messageId' => 1,
				'type'      => 'file',
				'filename'  => 'foo.php'
			],
			'expected' => [
				'messageId' => 1,
				'type'      => 'file',
				'filename'  => 'foo.php'
			]
		];
	}

	/**
	 * @return array
	 */
	protected function delete(): array
    {
		return [
			'data' => 1
		];
	}

	/**
	 * @return array
	 */
	protected function getList(): array
    {
		return [
			'expected' => [
				[
					'messageId' => 1,
					'type'      => 'image',
					'filename'  => 'foo.jpg',
					'createdAt' => '2017-08-18 07:28:02'
				]
			]
		];
	}

	/**
	 * @return array
	 */
	protected function getById(): array
    {
		return [
			'data' => '1',
			'expected' => 				[
				'messageId' => 1,
				'type'      => 'image',
				'filename'  => 'foo.jpg',
				'createdAt' => '2017-08-18 07:28:02'
			]
		];
	}

}