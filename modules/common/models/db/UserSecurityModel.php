<?php

namespace app\modules\common\models\db;

use app\components\ArPopulateTrait;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $user
 * @property string $hash_id
 * @property string $confirmation_hash
 * @property integer $confirmed
 * @property string $reset_password_hash
 * @property integer $last_fail_auth_count
 */
class UserSecurityModel extends ActiveRecord
{
    use ArPopulateTrait;

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

            ['hash_id', 'required'],
            ['hash_id', 'string', 'max' => 32],

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