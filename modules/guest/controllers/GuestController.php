<?php

namespace app\modules\guest\controllers;

use yii\web\Controller;
use app\modules\guest\models\forms\SignUpForm;
use app\modules\guest\models\forms\SignInForm;

/**
 * Default controller for the `guest` module
 */
class GuestController extends Controller
{
    public function actionSignUp() {
        $signUpForm = new SignUpForm();
        if($signUpForm->load(\Yii::$app->request->post()) && $signUpForm->signUp()) {
            die('Sign-up success'); // todo: auth and redirect to user module
        }

        return $this->render('sign-up', compact('signUpForm'));
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSignIn()
    {
        $signInForm = new SignInForm();
        if ($signInForm->load(\Yii::$app->request->post()) && $signInForm->signIn()) {
//            return $this->goBack(); todo go to lists of rss
        }

        return $this->render('sign-in', compact('signInForm'));
    }
}
