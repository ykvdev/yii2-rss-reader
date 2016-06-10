<?php

namespace app\modules\guest\controllers;

use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\modules\guest\models\forms\SignUpForm;
use app\modules\guest\models\forms\SignInForm;
use app\modules\guest\models\forms\ResendConfirmMailForm;

class GuestController extends Controller
{
    public function actionSignUp() {
        $model = new SignUpForm();
        if($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($model->save()) {
                $model->sendMail('confirmation', 'Подтверждение e-mail адреса', ['link' => $model->getConfirmationLink()]);

                \Yii::$app->session->setFlash('info', 'Вам необходимо подтвердить ваш e-mail адрес.
                Для этого воспользуйтесь ссылкой из письма отправленного вам на почту.');

                if ($userRedirect = $model->signIn()) {
                    return $userRedirect;
                }
            }
        }

        return $this->render('sign-up', compact('model'));
    }

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

    public function actionResendConfirmMail($email) {
        $model = new ResendConfirmMailForm();
        $model->load([$model->formName() => ['email' => $email]]);
        if(\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } elseif($model->validate()) {
            $model->sendMail('confirmation', 'Подтверждение e-mail адреса', ['link' => $model->getConfirmationLink()]);
            \Yii::$app->session->setFlash('info', 'Повторное письмо, со ссылкой для подтверждения e-mail адреса, отправлено');
        } else {
            $errors = $model->getFirstErrors();
            \Yii::$app->session->setFlash('danger', array_shift($errors));
        }

        return $this->goBack();
    }
}
