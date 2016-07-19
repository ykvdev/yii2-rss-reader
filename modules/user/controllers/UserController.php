<?php

namespace app\modules\user\controllers;

use app\modules\user\models\forms\ChangeEmailForm;
use app\modules\user\models\forms\ChangePasswordForm;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public function actionChangeEmail() {
        $model = new ChangeEmailForm(['id' => \Yii::$app->user->identity->id]);
        $model->populateBy('id', 'email');
        if($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($model->changeEmail()) {
                \Yii::$app->session->addFlash('info', \Yii::t('user',
                    'Your e-mail address has been changed. New e-mail confirm letter has been sent.'));
            }
        }

        return $this->render('change-email', compact('model'));
    }

    public function actionChangePassword() {
        $model = new ChangePasswordForm(['id' => \Yii::$app->user->identity->id]);
        $model->populateBy('id');
        if($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($model->changePassword()) {
                \Yii::$app->session->addFlash('info', \Yii::t('user', 'Your password has been changed'));
            }
        }

        return $this->render('change-password', compact('model'));
    }

    public function actionSignOut()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
