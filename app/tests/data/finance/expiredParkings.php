<?php
/**
 * @author Tarasenko Andrii
 * @date: 13.10.17
 */

$status = \App\Modules\Finance\Components\FinanceModelFactory::getClass(\App\Modules\Finance\Components\FinanceModelFactory::PARKING)::TYPE_ACTIVE;
$expired = (new \yii\i18n\Formatter())->asDatetime(time(), \App\Components\BaseModel::DB_DATE_TIME_FORMAT);


return [
    'data' => [
        [
            'id' => 1,
            'userId' => 1,
            'typeId' => 1,
            'amount' => 1.05,
            'rate' => 1.1,
            'status' => $status,
            'createdAt' => $expired,
        ],
        [
            'id' => 2,
            'userId' => 1,
            'typeId' => 1,
            'amount' => 0.15,
            'rate' => 0.41,
            'status' => $status,
            'createdAt' => $expired,
        ],
        [
            'id' => 3,
            'userId' => 1,
            'typeId' => 1,
            'amount' => 12.15,
            'rate' => 6.23,
            'status' => $status,
            'createdAt' => $expired,
        ]
    ]
];
