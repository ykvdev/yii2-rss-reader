<?php

namespace app\modules\common\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $registered_at
 * @property integer $activated
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'registered_at',
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'registered_at'], 'required'],
            [['registered_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['activated'], 'boolean'],
            [['email'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'message' => 'The email has already been taken.'],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedModels()
    {
        return $this->hasMany(FeedModel::className(), ['user' => 'id']);
    }

    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        if($this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        return true;
    }
}
