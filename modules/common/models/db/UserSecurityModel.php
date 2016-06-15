<?php

namespace app\modules\common\models\db;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $user
 * @property string $confirmation_hash
 * @property integer $confirmed
 * @property string $reset_password_hash
 * @property integer $last_fail_auth_count
 */
class UserSecurityModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'users_security';
    }

    public function rules()
    {
        return [
            ['user', 'required'],
            ['user', 'integer'],
            ['user', 'unique', 'targetAttribute' => 'user'],
            ['user', 'exist', 'skipOnError' => true, 'targetClass' => UserModel::className(),
                'targetAttribute' => ['user' => 'id']],

            ['confirmation_hash', 'string', 'max' => 32],

            ['confirmed', 'boolean'],

            ['reset_password_hash', 'string', 'max' => 32],

            ['last_fail_auth_count', 'integer'],
        ];
    }

    /**
     * @return UserModel
     */
    public function getUserModel()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user'])->one();
    }
}