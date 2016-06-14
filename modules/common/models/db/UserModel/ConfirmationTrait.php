<?php

namespace app\modules\common\models\db\UserModel;

use app\modules\common\models\db\UserModel;
use yii\helpers\Url;

trait ConfirmationTrait
{
    /**
     * @return bool
     */
    public function sendConfirmationMail() {
        /** @var $this UserModel */
        return $this->sendMail(
            'confirmation',
            'Подтверждение e-mail адреса',
            ['link' => $this->getConfirmationLink()]
        );
    }

    /**
     * @return string
     */
    public function getConfirmationLink() {
        /** @var $this UserModel */
        return Url::toRoute([
            '/common/user/confirmation-email',
            'email' => $this->email,
            'hash' => $this->getConfirmationHash()
        ], true);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getConfirmationHash() {
        /** @var $this UserModel */
        return md5($this->email . $this->registered_at . $this->id . $this->email);
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function validateConfirmationHash($hash) {
        /** @var $this UserModel */
        return $this->getConfirmationHash() === $hash;
    }
}