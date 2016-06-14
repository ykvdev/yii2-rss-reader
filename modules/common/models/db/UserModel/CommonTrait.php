<?php

namespace app\modules\common\models\db\UserModel;

use app\modules\common\models\db\UserModel;
use yii\web\Response;

trait CommonTrait
{
    /**
     * @param bool|false $rememberMe
     * @param bool|true $withRedirect
     * @return Response|bool
     */
    public function signIn($rememberMe = false, $withRedirect = true) {
        /** @var UserModel $this */
        $auth = \Yii::$app->user->login($this, $rememberMe ? \Yii::$app->params['user']['sign-in']['remember-me-seconds'] : 0);
        if(!$auth) {
            return false;
        }

        if($withRedirect) {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['user']['sign-in']['redirect-route']);
        } else {
            return true;
        }
    }
}