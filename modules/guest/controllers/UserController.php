<?php

namespace app\modules\guest\controllers;

use app\modules\guest\models\forms\ResetPasswordForm;
use app\modules\guest\models\forms\ResetPasswordRequestForm;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\modules\guest\models\forms\SignInForm;
use app\modules\guest\models\forms\ResendConfirmationMailForm;

class UserController extends Controller
{
    public function actionSignIn()
    {
        $model = new SignInForm();
        if ($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($userRedirect = $model->signIn()) {
                return $userRedirect;
            }
        }

        return $this->render('sign-in', compact('model'));
    }

    public function actionResendConfirmationMail($email) {
        $model = new ResendConfirmationMailForm(compact('email'));
        if($model->sendConfirmationMail()) {
            \Yii::$app->session->setFlash('info',
                'Повторное письмо, со ссылкой для подтверждения e-mail адреса, отправлено');
        } else {
            $errors = $model->getFirstErrors();
            \Yii::$app->session->setFlash('danger', array_shift($errors));
        }

        return $this->goBack();
    }

    public function actionResetPasswordRequest($email = null) {
        $model = new ResetPasswordRequestForm(compact('email'));
        if($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($model->sendResetPasswordMail()) {
                \Yii::$app->session->setFlash('info', 'Вам было отправлено письмо для восстановления пароля');
            }
        }

        return $this->render('reset-password-request', compact('model'));
    }

    public function actionResetPassword($email, $hash) {
        $model = new ResetPasswordForm(compact('email', 'hash'));
        if(!$model->validate(['email', 'hash'])) {
            $errors = $model->getFirstErrors();
            \Yii::$app->session->setFlash('danger', array_shift($errors));
        } elseif($model->load(\Yii::$app->request->post()) && $userRedirect = $model->changePassword()) {
            \Yii::$app->session->setFlash('info', 'Ваш пароль изменен на новый');
            return $userRedirect;
        }

        return $this->render('reset-password', compact('model'));
    }
}