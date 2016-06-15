<?php

namespace app\modules\common\models\db\UserModel\services;

use app\modules\common\models\db\UserModel;
use yii\web\Response;
use yii\helpers\Html;

trait CommonTrait
{
    /**
     * @param bool|true $validateConfirmation
     * @param bool|false $rememberMe
     * @param bool|true $withRedirect
     * @return Response|bool
     */
    public function signIn($validateConfirmation = true, $rememberMe = false, $withRedirect = true) {
        /** @var $this UserModel */
        if($validateConfirmation && !$this->getUserSecurityModel()->confirmed) {
            $this->addError('email', sprintf(
                'Ваш e-mail не подтвержден.
                Вы должны перейти по ссылке из письма для подтверждения e-mail адреса.
                Если вы не получали это письмо, вы можете %s.',
                Html::a('запросить его повторно', ['/guest/user/resend-confirmation-mail', 'email' => $this->email])
            ));

            return false;
        }

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