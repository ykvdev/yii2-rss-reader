<?php

namespace app\modules\common\controllers;

use yii\web\Controller;
use app\modules\common\models\db\UserModel;

class UserController extends Controller
{
    public function actionResendConfirmMail($email) {

    }

    public function actionConfirmation($email, $hash) {
        /** @var $user UserModel */
        if(!($user = UserModel::findOne(['email' => $email]))) {
            \Yii::$app->session->setFlash('danger', 'Пользователя с e-mail адресом ' . $email . ' не найдено');
        } elseif(!$user->validateConfirmationHash($hash)) {
            \Yii::$app->session->setFlash('danger', 'Ссылка подтверждения e-mail адреса не верная');
        } else {
            if(!$user->confirmed) {
                $user->confirmed = 1;
                $user->save();
            }

            \Yii::$app->session->setFlash('info', 'Ваш e-mail адрес ' . $email . ' подтвержден');

            if(\Yii::$app->user->isGuest && $userRedirect = $user->signIn()) {
                return $userRedirect;
            }
        }

        return $this->goHome();
    }
}