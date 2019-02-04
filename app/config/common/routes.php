<?php
/**
 * Created by PhpStorm.
 * User: moneystream
 * Date: 16.08.17
 * Time: 15:19
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'subscriber' => 'subscribe/subscriber',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'POST' => 'create',
            'DELETE' => 'delete',
            'POST check' => 'check',
            'OPTIONS check' => 'options'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'user' => 'user/user',
            'finance/payout/source' => 'finance/payout-source',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'DELETE' => 'delete',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'finance/parking/type' => 'finance/parking-type',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'POST' => 'create',
            'PUT, PATCH {id}' => 'update',
            'OPTIONS' => 'options',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'user/aaa'
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'POST sign-in' => 'sign-in',
            'POST validate-token' => 'validate-token',
            'POST verify' => 'verify',
            'POST register' => 'register',
            'POST sign-out' => 'sign-out',
            'POST change-password' => 'change-password',
            'POST password-recovery' => 'password-recovery'
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'finance/parking',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'GET status' => 'status',
            'OPTIONS status' => 'options',
            'GET status?page=<page>' => 'status',
            'OPTIONS status?page=<page>' => 'options',
            'GET status/<status>' => 'status',
            'OPTIONS status/<status>' => 'options',
            'GET admin-status' => 'admin-status',
            'OPTIONS admin-status' => 'options',
            'GET admin-status?page=<page>' => 'admin-status',
            'OPTIONS admin-status?page=<page>' => 'options',
            'GET admin-status/<status>' => 'admin-status',
            'OPTIONS admin-status/<status>' => 'options',
            'GET total-count' => 'count',
            'OPTIONS total-count' => 'options',
            'GET admin-count' => 'admin-count',
            'OPTIONS admin-count' => 'options',
            'POST cancel' => 'cancel',
            'OPTIONS cancel' => 'options',
            'POST activate' => 'activate',
            'OPTIONS activate' => 'options',
            'GET statistic' => 'statistic',
            'OPTIONS statistic' => 'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'notification' => 'notification/notification',
        ],
        'pluralize' => false,
        'tokens' => ['{id}' => '<id:[a-z0-9]*>'],
        'extraPatterns' => [
            'GET user' => 'user',
            'POST seen' => 'seen',
            'OPTIONS seen' => 'options'
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'finance/balance' => 'finance/user-balance',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'GET user' => 'filter',
            'OPTIONS user' => 'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'finance/transaction',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'GET admin-status/<status>' => 'admin-filter',
            'OPTIONS admin-status/<status>' => 'options',
            'GET status/<status>' => 'filter',
            'OPTIONS status/<status>' => 'options',
            'GET last' => 'last',
            'OPTIONS last' => 'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'statistic/action',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'GET freezing' => 'freezing',
            'OPTIONS freezing' => 'options',
            'GET minexbank-reserve' => 'minexbank-reserve',
            'OPTIONS minexbank-reserve' => 'options',
            'GET hot-reserve' => 'hot-reserve',
            'OPTIONS hot-reserve' => 'options',
            'GET on-hand' => 'on-hand',
            'OPTIONS on-hand' => 'options',
            'GET subscriber-count' => 'subscriber-count',
            'OPTIONS subscriber-count' => 'options',
            'GET payout' => 'payout',
            'OPTIONS payout' => 'options',
            'GET parking-users' => 'parking-users',
            'OPTIONS parking-users' => 'options',
            'GET total-users' => 'total-users',
            'OPTIONS total-users' => 'options',
            'GET cold-wallet' => 'cold-wallet',
            'OPTIONS cold-wallet' => 'options',
            'GET total-supply' => 'total-supply',
            'OPTIONS total-supply' => 'options',
            'GET total-parking-amount' => 'total-parking-amount',
            'OPTIONS total-parking-amount',
            'GET parking' => 'parking',
            'OPTIONS parking' => 'options',
            'GET debts' => 'debts',
            'OPTIONS debts' => 'options',
            'GET debts-for-this-week' => 'debts-for-this-week',
            'OPTIONS debts-for-this-week' => 'options',
            'GET user-parking-chart' => 'user-parking-chart',
            'OPTIONS user-parking-chart' => 'options',
            'GET debts-chart' => 'user-parking-chart',
            'OPTIONS debts-chart' => 'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'statistic/chart',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'GET parking-chart' => 'parking-chart',
            'OPTIONS parking-chart' => 'options',
            'GET total-supply-chart' => 'total-supply-chart',
            'OPTIONS total-supply-chart' => 'options',
            'GET hot-reserve' => 'hot-reserve',
            'OPTIONS hot-reserve' => 'options',
            'GET payout' => 'payout',
            'OPTIONS payout' => 'options',
            'GET cold-wallet' => 'cold-wallet',
            'OPTIONS cold-wallet' => 'options',
            'GET total-users' => 'total-users',
            'OPTIONS total-users' => 'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'chat' => 'chat/chat',
        ],
        'pluralize' => false,
        'extraPatterns' => [
            'GET chat-history' => 'chat-history',
            'OPTIONS chat-history' => 'options',
            'GET chat-pending/<id>' => 'chat-pending',
            'OPTIONS chat-pending/<id>' => 'options',
            'POST create-chat' => 'create-chat',
            'OPTIONS create-chat' => 'options',
            'POST create-message' => 'create-message',
            'OPTIONS create-message' => 'options',
        ],
    ],
];