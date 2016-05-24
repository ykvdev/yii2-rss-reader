<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'yii2-rss-reader',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'guest/guest/sign-in',
    'modules' => [
        'guest' => [
            'class' => 'app\modules\guest\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
    ],
    'bootstrap' => [
        'log',
        'app\components\Bootstrap'
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '82d8SvpQuyZkkraNzrXsXqe7CT9hLtSJ',
            'enableCsrfValidation' => true
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true, // for remember me functionality
            'loginUrl' => ['guest/guest/sign-in']
        ],
        'errorHandler' => [
            'errorAction' => 'user/error',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::className(),
            'htmlLayout' => 'layouts/main-html',
            'textLayout' => 'layouts/main-text',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['noreply@rss-reader.com' => 'Rss Reader'],
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_ENV_DEV,
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
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*']
    ];
}

return $config;
