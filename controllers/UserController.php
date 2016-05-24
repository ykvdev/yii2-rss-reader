<?php

namespace app\controllers;

use app\models\forms\RegistrationForm;
use Yii;
use app\components\Controller;
use app\models\forms\LoginForm;

class UserController extends Controller
{
    public function actions()
    {
        return array_merge(parent::actions(), [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ]);
    }


}
