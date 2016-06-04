<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'yii2-rss-reader',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'guest/guest/sign-in',
    'layoutPath' => '@app/modules/common/views/layouts',
    'modules' => [
        'guest' => [
            'class' => 'app\modules\guest\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'common' => [
            'class' => 'app\modules\common\Module',
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
            'identityClass' => 'app\modules\common\models\db\UserModel',
            'enableAutoLogin' => true, // for remember me functionality
            'loginUrl' => ['guest/guest/sign-in']
        ],
        'errorHandler' => [
            'errorAction' => 'common/common/error',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::className(),
            'viewPath' => '@app/modules/common/mail',
            'htmlLayout' => 'layouts/main-html',
            'textLayout' => 'layouts/main-text',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['noreply@rss-reader.com' => 'RSS Reader'],
            ],
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
