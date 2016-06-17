<?php

namespace app\modules\common\models\db\UserModel\services;

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

    function sendNewConfirmationMail() {
        /** @var $this UserModel */
        return $this->sendMail(
            'new-confirmation',
            'Подтверждение нового e-mail адреса',
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
            'hash' => $this->getUserSecurityModel()->confirmation_hash
        ], true);
    }
}