<?php

namespace app\modules\common\controllers;

use yii\web\Controller;
use yii\web\ServerErrorHttpException;
use app\modules\common\models\db\UserModel;

class UserController extends Controller
{
    /**
     * @param string $email
     * @param string $hash
     * @return \yii\web\Response
     * @throws ServerErrorHttpException
     */
    public function actionConfirmation($email, $hash) {
        /** @var $user UserModel */
        if(!($user = UserModel::findOne(['email' => $email]))) {
            \Yii::$app->session->setFlash('danger', 'Пользователя с e-mail адресом ' . $email . ' не найдено');
        } elseif(!$user->validateConfirmationHash($hash)) {
            \Yii::$app->session->setFlash('danger', 'Ссылка подтверждения e-mail адреса не верная');
        } else {
            if(!$user->confirmed) {
                $user->confirmed = 1;
                if (!$user->save()) {
                    $errors = $user->getFirstErrors();
                    throw new ServerErrorHttpException($errors ? array_shift($errors) : null);
                }
            }

            \Yii::$app->session->setFlash('info', 'Ваш e-mail адрес ' . $email . ' подтвержден');

            if(\Yii::$app->user->isGuest && $userRedirect = $user->signIn()) {
                return $userRedirect;
            }
        }

        return $this->goHome();
    }
}