<?php

namespace app\modules\common\models\db\UserModel;

use app\modules\common\models\db\UserModel;

trait IdentityTrait
{
    public static function findIdentity($id)
    {
        return UserModel::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        /** @var $this UserModel */
        return $this->id;
    }

    public function getAuthKey()
    {
        /** @var $this UserModel */
        return \Yii::$app->security->generatePasswordHash($this->id . $this->registered_at . $this->email
            . \Yii::$app->params['user']['sign-in']['auth-key-secret']);
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}