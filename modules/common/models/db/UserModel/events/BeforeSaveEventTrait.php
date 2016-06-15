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
        $this->setRegisteredDateIfNeed();

        return true;
    }

    private function generatePasswordIfNeed() {
        /** @var $this UserModel */
        if($this->isAttributeChanged('password')) {
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);
        }
    }

    private function setRegisteredDateIfNeed() {
        /** @var $this UserModel */
        if($this->isNewRecord) {
            $this->registered_at = date('Y-m-d H:i:s');
        }
    }
}