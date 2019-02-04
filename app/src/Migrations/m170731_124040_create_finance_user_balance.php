<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date 31.07.17
 */

use App\Components\CoreMySQLMigration;

class m170731_124040_create_finance_user_balance extends CoreMySQLMigration
{
	public $table = '{{%finance_user_balance}}';

	public $indexes = [ 'userId' ];

	public function safeUp()
	{
		$this->createNewTableWithIndexes([
			'id' => $this->primaryKey(),
			'userId' => $this->integer()->notNull()->unsigned(),
			'balance' => $this->bigInteger()->notNull()->unsigned(),
			'lastSync' => $this->datetime()->notNull(),
		]);
	}
}
