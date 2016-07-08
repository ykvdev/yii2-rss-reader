<?php

$config = [
    'id' => 'yii2-rss-reader',
    'name' => 'RSS Reader',
    'homeUrl' => 'http://bl-gener',
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'guest/user/sign-in',
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
            'loginUrl' => ['guest/user/sign-in']
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
        'db' => require(__DIR__ . '/common/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'ruleConfig' => [
                'class' => '\app\components\LanguageUrlRule'
            ],
            'rules' => require(__DIR__ . '/web/url-rules.php'),
        ],
        'assetManager' => [
            'bundles' => YII_ENV_DEV ? ['\app\assets\AppAsset'] : require __DIR__ . '/web/assets-compressed.php'
        ],
    ],
    'params' => require(__DIR__ . '/common/params.php'),
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
