<?php

namespace app\modules\guest\controllers;

use yii\web\Controller;
use app\modules\guest\models\forms\SignUpForm;
use app\modules\guest\models\forms\SignInForm;

class GuestController extends Controller
{
    public function actionSignUp() {
        $signUpForm = new SignUpForm();
        if($signUpForm->load(\Yii::$app->request->post()) && ($userModel = $signUpForm->signUp())) {
            \Yii::$app->user->login($userModel);
            \Yii::$app->session->setFlash('info', 'Вам необходимо подтвердить ваш e-mail адрес.
            Для этого воспользуйтесь ссылкой из письма отправленного вам на почту.');
            return $this->redirect(\Yii::$app->params['user']['sign-in']['redirect-route']);
        }

        return $this->render('sign-up', compact('signUpForm'));
    }

    public function actionSignIn()
    {
        $signInForm = new SignInForm();
        if ($signInForm->load(\Yii::$app->request->post()) && $signInForm->signIn()) {
            return $this->redirect(\Yii::$app->params['user']['sign-in']['redirect-route']);
        }

        return $this->render('sign-in', compact('signInForm'));
    }
}
