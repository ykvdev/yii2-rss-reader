<?php

namespace app\modules\common\controllers;

use omnilight\captcha\algorithms\Numbers;
use omnilight\captcha\CaptchaAction;
use yii\web\Controller;

class CommonController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => CaptchaAction::className(),
                'algorithm' => function() {
                    $algo = new Numbers;
                    $algo->minLength = 4;
                    $algo->maxLength = 4;
                    return $algo;
                },
            ],
        ];
    }
}
