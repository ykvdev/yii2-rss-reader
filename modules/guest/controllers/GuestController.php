<?php

namespace app\modules\guest\controllers;

use yii\web\Controller;
use app\modules\guest\models\forms\SignUpForm;
use app\modules\guest\models\forms\SignInForm;

class GuestController extends Controller
{
    public function actionSignUp() {
        $signUpForm = new SignUpForm();
        if($signUpForm->load(\Yii::$app->request->post()) && $signUpForm->signUp()) {
            die('Sign-up success'); // todo: auth and redirect to user module
        }

        return $this->render('sign-up', compact('signUpForm'));
    }

    public function actionSignIn()
    {
        $signInForm = new SignInForm();
        if ($signInForm->load(\Yii::$app->request->post()) && $signInForm->signIn()) {
            die('Sign in success'); // todo: go to lists of rss
        }

        return $this->render('sign-in', compact('signInForm'));
    }
}
