<?php

namespace app\modules\common\models\db;

use app\components\ArPopulateTrait;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property integer $id
 * @property integer $user
 * @property string $url
 * @property string $title
 * @property string $subscribed_at
 */
class FeedModel extends ActiveRecord
{
    use ArPopulateTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feeds';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user', 'required'],
            ['user', 'integer'],
            ['user', 'exist', 'skipOnError' => true, 'targetClass' => UserModel::className(),
                'targetAttribute' => ['user' => 'id']],

            ['url', 'required'],
            ['url', 'url'],
            ['url', 'string', 'max' => 255],

            ['title', 'required'],
            ['title', 'string', 'max' => 255],

            ['subscribed_at', 'required'],
            ['subscribed_at', 'date', 'format' => 'php:Y-m-d H:i:s'],

            [['user', 'url'], 'unique', 'targetAttribute' => ['user', 'url'],
                'message' => 'Такой RSS канал уже существует'],
            [['user', 'title'], 'unique', 'targetAttribute' => ['user', 'title'],
                'message' => 'Такой RSS канал уже существует'],
        ];
    }

    /**
     * @return UserModel
     */
    public function getUserModel() {
        return $this->hasOne(UserModel::className(), ['id' => 'user'])->one();
    }

    /**
     * @return NewModel[]
     */
    public function getNewModels()
    {
        return $this->hasMany(NewModel::className(), ['feed' => 'id'])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsQuery()
    {
        return $this->hasMany(NewModel::className(), ['feed' => 'id']);
    }

    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)) {
            return false;
        }

        if($insert) {
            $this->subscribed_at = new Expression('NOW()');
        }

        return true;
    }

    /**
     * @param int $feedId
     * @return bool|string
     */
    public static function getIconPath($feedId) {
        $iconsPath = \Yii::getAlias("@webroot/uploads/feed_icons");
        $findIcons = glob("{$iconsPath}/{$feedId}.*");
        if(isset($findIcons[0])) {
            return $iconsPath . '/' . basename($findIcons[0]);
        } else {
            return false;
        }
    }

    /**
     * @param int $feedId
     * @return bool|string
     */
    public static function getIconUri($feedId) {
        $findIcons = glob(\Yii::getAlias("@webroot/uploads/feed_icons/{$feedId}.*"));
        if(isset($findIcons[0])) {
            return \Yii::getAlias("@web/uploads/feed_icons/") . basename($findIcons[0]);
        } else {
            return false;
        }
    }
}
