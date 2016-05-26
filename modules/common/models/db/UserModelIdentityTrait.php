<?php

namespace app\modules\common\models\db;

trait UserModelIdentityTrait
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
        return password_hash($this->id, $this->registered_at, $this->email);
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}