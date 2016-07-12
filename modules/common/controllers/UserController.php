<?php

namespace app\modules\common\controllers;

use app\modules\common\models\forms\ConfirmationForm;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionConfirmationEmail($hash_id, $confirmation_hash) {
        $model = new ConfirmationForm(compact('hash_id', 'confirmation_hash'));
        $model->populateBy(['hash_id', 'confirmation_hash']);
        if($userRedirect = $model->confirm()) {
            \Yii::$app->session->setFlash('info', \Yii::t('common', 'Your e-mail address has been confirmed'));
            return $userRedirect;
        } else {
            $errors = $model->getFirstErrors();
            \Yii::$app->session->setFlash('danger', array_shift($errors));
        }

        return $this->goHome();
    }
}