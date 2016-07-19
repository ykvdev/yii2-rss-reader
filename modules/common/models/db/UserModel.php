<?php

namespace app\modules\common\models\db;

use app\components\ArPopulateTrait;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $registered_at
 */
class UserModel extends ActiveRecord implements IdentityInterface
{
    use ArPopulateTrait,
        UserModel\services\IdentityTrait,
        UserModel\services\CommonTrait,
        UserModel\services\ConfirmationTrait,
        UserModel\services\MailTrait,
        UserModel\services\ResetPasswordTrait,
        UserModel\events\BeforeSaveEventTrait,
        UserModel\events\AfterSaveEventTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
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

            ['password', 'required'],
            ['password', 'string', 'min' => 3, 'max' => 255],

            ['registered_at', 'required'],
            ['registered_at', 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'E-mail',
            'password' => Yii::t('common', 'Password'),
            'registered_at' => Yii::t('common', 'Registered at'),
        ];
    }

    /**
     * @return UserSecurityModel
     */
    public function getUserSecurityModel() {
        return $this->hasOne(UserSecurityModel::className(), ['user' => 'id'])->one();
    }

    /**
     * @param $limit null|int
     * @return FeedModel[]
     */
    public function getFeedModels($limit = null)
    {
        $query = $this->hasMany(FeedModel::className(), ['user' => 'id']);

        if($limit) {
            $query->limit($limit);
        }

        return $query->all();
    }
}
