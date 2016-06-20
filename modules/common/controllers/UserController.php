<?php

namespace app\modules\common\controllers;

use app\modules\common\models\forms\ConfirmationForm;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionConfirmationEmail($email, $hash) {
        $model = new ConfirmationForm(compact('email', 'hash'));
        $model->populateBy('email');
        if($userRedirect = $model->confirm()) {
            \Yii::$app->session->setFlash('info', 'Ваш e-mail адрес ' . $email . ' подтвержден');
            return $userRedirect;
        } else {
            $errors = $model->getFirstErrors();
            \Yii::$app->session->setFlash('danger', array_shift($errors));
        }

        return $this->goHome();
    }
}