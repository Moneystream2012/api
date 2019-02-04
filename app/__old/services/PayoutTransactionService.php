<?php

namespace app\services;

use Yii;
use app\models\PayoutTransaction;

/**
 * Service worker for parking.
 */
class PayoutTransactionService extends Service {
	/**
	 * Add new transaction.
	 *
	 * @param int $parkingId
	 * @param string $txid
	 * @return object|null
	 */
	public function add($parkingId, $txid) {
		$transactionExists = $this->find(['parking_id'=>$parkingId]);
		if ($transactionExists)
			return null;

		$model = new PayoutTransaction();
		$model->parking_id = $parkingId;
		$model->txid = $txid;
		$model->created = time();
		$model->spended = 0;

		return $model->save() ? $model : null;
	}



	/**
	 * Find.
	 *
	 * @param string|array $clause
	 * @param array $params
	 * @return object|null
	 */
	public function find($clause = null, $params = null) {
		if ($clause == null)
			return PayoutTransaction::find()->one();
		elseif ($params == null)
			return PayoutTransaction::find()->where($clause)->one();
		else
			return PayoutTransaction::find()->where($clause, $params)->one();
	}



	/**
	 * Spend.
	 *
	 * @param string $txid
	 * @return boolean
	 */
	public function spendByHash($txid) {
		$tx = $this->find(['txid'=>$txid]);

		if (!$tx)
			return false;

		$tx->spended = time();
		return $tx->save();
	}



	/**
	 * Spend.
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function spendById($id) {
		$tx = $this->find(['id'=>$id]);

		if (!$tx)
			return false;

		$tx->spended = time();
		return $tx->save();
	}



	/**
	 * Delete.
	 *
	 * @param string $txid
	 * @return boolean
	 */
	public function deleteByHash($txid) {
		$tx = $this->find(['txid'=>$txid]);

		if (!$tx)
			return false;

		return $tx->delete();
	}



	/**
	 * Delete.
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function deleteById($id) {
		$tx = $this->find(['id'=>$id]);

		if (!$tx)
			return false;

		return $tx->delete();
	}
}