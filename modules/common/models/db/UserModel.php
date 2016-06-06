<?php

namespace app\modules\common\models\db;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $registered_at
 * @property integer $confirmed
 */
class UserModel extends \yii\db\ActiveRecord implements IdentityInterface
{
    use UserModelIdentityTrait,
        UserModelServiceTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        if($this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        if($insert) {
            $this->registered_at = date('Y-m-d H:i:s');
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ['login', 'string', 'min' => 2, 'max' => 255],
            // если бы был логин, то нужно было бы добавить проверку на длину мин 2 символа

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 50],
            ['email', 'unique', 'targetAttribute' => 'email'],

            ['password', 'required'],
            ['password', 'string', 'min' => 3, 'max' => 255],

            ['registered_at', 'required'],
            ['registered_at', 'date', 'format' => 'php:Y-m-d H:i:s'],

            ['confirmed', 'boolean'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
            'registered_at' => 'Дата регистрации',
            'confirmed' => 'Подтвержден'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedModels()
    {
        return $this->hasMany(FeedModel::className(), ['user' => 'id']);
    }
}
