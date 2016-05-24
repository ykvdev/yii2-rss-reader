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

    public function actionRegistration() {
        $registrationForm = new RegistrationForm();
        if($registrationForm->load(Yii::$app->request->post()) && $registrationForm->registration()) {
            die('Register success'); // todo: auth and redirect to user space
        }

        return $this->render('registration', compact('registrationForm'));
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack(); todo go to lists of rss
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
