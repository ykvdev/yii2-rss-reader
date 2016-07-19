<?php

namespace app\modules\guest\controllers;

use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\modules\guest\models\forms\SignUpForm;

class GuestController extends Controller
{
    public function actionSignUp() {
        $model = new SignUpForm();
        if($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($userRedirect = $model->signUp()) {
                \Yii::$app->session->addFlash('info',
                \Yii::t('guest', 'You are need to confirm your e-mail. For this, use the link from confirmation mail.'));
                return $userRedirect;
            }
        }

        return $this->render('sign-up', compact('model'));
    }
}
