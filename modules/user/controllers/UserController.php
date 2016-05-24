<?php

namespace app\modules\user\controllers;

use yii\web\Controller;

class UserController extends Controller
{
    public function actionSignOut()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
