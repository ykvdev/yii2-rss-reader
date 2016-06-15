<?php

namespace app\modules\common\models\db;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user
 * @property string $site_url
 * @property string $rss_uri
 * @property string $subscribed_at
 */
class FeedModel extends ActiveRecord
{
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

            ['site_url', 'required'],
            ['site_url', 'url'],
            ['site_url', 'string', 'max' => 255],

            ['rss_uri', 'required'],
            ['rss_uri', 'string', 'max' => 255],

            ['subscribed_at', 'required'],
            ['subscribed_at', 'date', 'format' => 'php:Y-m-d H:i:s'],

            [['user', 'site_url', 'rss_uri'], 'unique', 'targetAttribute' => ['user', 'site_url', 'rss_uri'],
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
}
