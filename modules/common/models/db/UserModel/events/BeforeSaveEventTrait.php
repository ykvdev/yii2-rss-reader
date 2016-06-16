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
}