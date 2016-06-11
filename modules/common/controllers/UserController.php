<?php

namespace app\modules\common\controllers;

use app\modules\common\models\forms\ConfirmationForm;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionConfirmationEmail($email, $hash) {
        $model = new ConfirmationForm(compact('email', 'hash'));
        if($model->confirm()) {
            \Yii::$app->session->setFlash('info', 'Ваш e-mail адрес ' . $email . ' подтвержден');

            if(\Yii::$app->user->isGuest && $userRedirect = $model->signIn()) {
                return $userRedirect;
            }
        } else {
            $errors = $model->getFirstErrors();
            \Yii::$app->session->setFlash('danger', array_shift($errors));
        }

        return $this->goHome();
    }
}