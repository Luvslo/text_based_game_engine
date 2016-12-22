<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'gothic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dfsw44w3erfsdf43323edd~~~',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'game/intro',
                    'route' => 'game/intro',
                ],
                [
                    'class' => yii\rest\UrlRule::class,
                    'controller' => ['user', 'question', 'answer', 'active-equipment'],
                    'pluralize' => false,
                    'except' => ['delete'],
                ],
                'answer_select' => [
                    'pattern' => 'question/<question_id:\d+>/<controller>/<id:\d+>/selector',
                    'route' => '<controller>/select',
                ],
                'fight' => [
                    'pattern' => 'answer/<answer_id:\d+>/fight/<id:\d+>',
                    'route' => 'fight/view',
                ],
                'fight_attack' => [
                    'pattern' => 'answer/<answer_id:\d+>/fight/<fight_id:\d+>/attack/<id:\d+>',
                    'route' => 'fight/attack',
                ],
                'fight_result' => [
                    'pattern' => 'answer/<answer_id:\d+>/fight/<id:\d+>/result',
                    'route' => 'fight/result',
                ],
                'login' => [
                    'pattern' => 'auth/login',
                    'route' => 'auth/login',
                ],

            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'format' => yii\web\Response::FORMAT_JSON,
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                  
                }
            },
        ],
    ],
    'modules' => [

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
