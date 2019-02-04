<?php

use yii\db\Migration;

class m171109_131024_update_parking_fields extends Migration
{
    public function up()
    {
        $parkings = Yii::$app->db->createCommand('SELECT * FROM {{%finance_parking}}')->queryAll();

        foreach ($parkings as $parking) {

            if (empty($parking['endDate']) && empty($parking['returnedAmount'])) {

                $parkingType = $this->getParkingType($parking['typeId']);

                Yii::$app->db->createCommand('UPDATE {{%finance_parking}} SET endDate = :endDate, returnedAmount = :returnedAmount WHERE id=:id', [
                    'endDate' => $this->getEndDate($parkingType, $parking['createdAt']),
                    'returnedAmount' => $this->getReturnedAmount($parking),
                    'id' => $parking['id']
                ])->execute();

            }
        }

        return true;
    }

    private function getParkingType($id): array
    {
        $parkingType = Yii::$app->db->createCommand('SELECT * FROM {{%finance_parking_type}} where id = :typeId', [
            'typeId' => $id
        ])->queryOne();

        return $parkingType;
    }

    private function getEndDate(array $data, string $createdAt)
    {
        $endDate = new \DateTime($createdAt);
        $endDate->add(new \DateInterval('P' . $data['period'] . 'D'));
        $timestamp = $endDate->getTimestamp();
        return Yii::$app->formatter->asDatetime($timestamp);
    }

    private function getReturnedAmount(array $data)
    {
        return $data['amount'] * $data['rate'] / 100;
    }

    public function safeDown()
    {

    }
}
