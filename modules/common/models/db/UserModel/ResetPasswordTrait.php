<?php

namespace app\modules\common\models\db\UserModel;

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
            'hash' => $this->getResetPasswordHash()
        ], true);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getResetPasswordHash() {
        /** @var $this UserModel */
        return md5($this->email . $this->registered_at . $this->email);
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function validateResetPasswordHash($hash) {
        /** @var $this UserModel */
        return $this->getResetPasswordHash() === $hash;
    }
}