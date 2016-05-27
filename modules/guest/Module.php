<?php

namespace app\modules\guest;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require __DIR__ . '/config.php');
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function ($rule, $action) {
                            \Yii::$app->getResponse()->redirect(\Yii::$app->params['user']['sign-in']['redirect-route'])->send();
                        }
                    ]
                ]
            ]
        ];
    }
}
