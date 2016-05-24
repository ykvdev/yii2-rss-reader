<?php

namespace app\modules\common\models\db;

use Yii;

/**
 * This is the model class for table "feeds".
 *
 * @property integer $id
 * @property integer $user
 * @property string $site_url
 * @property string $rss_uri
 * @property string $subscribed_at
 */
class FeedModel extends \yii\db\ActiveRecord
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
            [['user', 'site_url', 'rss_uri', 'subscribed_at'], 'required'],
            [['user'], 'integer'],
            [['subscribed_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['site_url'], 'url'],
            [['site_url', 'rss_uri'], 'string', 'max' => 255],
            [['user', 'site_url', 'rss_uri'], 'unique', 'targetAttribute' => ['user', 'site_url', 'rss_uri'], 'message' => 'The combination of User, Site Url and Rss Uri has already been taken.'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserModel() {
        return $this->hasOne(UserModel::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewModels()
    {
        return $this->hasMany(NewModel::className(), ['feed' => 'id']);
    }
}
