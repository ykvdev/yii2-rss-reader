<?php

namespace app\modules\common\models\db\UserModel\events;

use app\modules\common\models\db\UserModel;
use app\modules\common\models\db\UserSecurityModel;

trait AfterSaveEventTrait
{
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        $this->createSecurityRowIfNeed();
    }

    private function createSecurityRowIfNeed() {
        /** @var $this UserModel */
        if($this->isNewRecord) {
            (new UserSecurityModel([
                'user' => $this->id,
                'confirm_hash' => md5(time() . mt_rand(0, 100) . uniqid())
            ]))->save();
        }
    }
}