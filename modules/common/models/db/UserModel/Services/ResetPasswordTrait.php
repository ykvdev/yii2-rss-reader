<?php

namespace app\modules\common\models\db\UserModel\services;

use app\modules\common\models\db\UserModel;
use yii\helpers\Url;

trait ResetPasswordTrait
{
    public function sendResetPasswordMail() {
        /** @var $this UserModel */
        return $this->sendMail(
            'reset-password-request',
            'Смена пароля',
            ['link' => $this->getResetPasswordLink()]
        );
    }

    /**
     * @return string
     */
    public function getResetPasswordLink() {
        /** @var $this UserModel */
        return Url::toRoute([
            '/guest/user/reset-password',
            'email' => $this->email,
            'hash' => $this->getUserSecurityModel()->reset_password_hash
        ], true);
    }
}