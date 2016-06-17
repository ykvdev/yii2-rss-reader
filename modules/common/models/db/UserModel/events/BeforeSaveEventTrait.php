<?php

namespace app\modules\common\models\db\UserModel\events;

use app\modules\common\models\db\UserModel;

trait BeforeSaveEventTrait
{
    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        $this->generatePasswordIfNeed();
        $this->setRegisteredDateIfNeed($insert);
        $this->setNewConfirmationIfNeed($insert);

        return true;
    }

    private function generatePasswordIfNeed() {
        /** @var $this UserModel */
        if($this->isAttributeChanged('password')) {
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);
        }
    }

    private function setRegisteredDateIfNeed($insert) {
        /** @var $this UserModel */
        if($insert) {
            $this->registered_at = date('Y-m-d H:i:s');
        }
    }

    private function setNewConfirmationIfNeed($insert) {
        /** @var $this UserModel */
        if(!$insert && $this->getDirtyAttributes(['email'])) {
            $securityModel = $this->getUserSecurityModel();
            $securityModel->confirmation_hash = md5(time() . mt_rand(0, 100) . uniqid());
            $securityModel->confirmed = 0;
            $securityModel->save();
        }
    }
}